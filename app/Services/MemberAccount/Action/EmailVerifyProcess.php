<?php

namespace App\Services\MemberAccount\Action;

use App\Core\Services\MemberAccount\Dtos\EmailVerifyDto;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\EmailPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossNotificationDto;
use Jsadways\DataApi\Facades\CrossFacade;
use Jsadways\LaravelSDK\Exceptions\ControllerException;
use Random\RandomException;
use Throwable;

class EmailVerifyProcess
{
    const string RATE_LIMIT_PREFIX = 'EMAIL_RATE_LIMIT_';
    const string VERIFICATION_PREFIX = 'EMAIL_VERIFY_';
    const string VERIFIED_PREFIX = 'EMAIL_VERIFIED_';
    const int RATE_LIMIT_MINUTES = 1;
    const int VERIFICATION_EXPIRE_MINUTES = 5;
    const int VERIFIED_EXPIRE_MINUTES = 30;
    const int TEMP_JWT_EXPIRE_MINUTES = 15;

    private string $generatedUuid;
    private string $identifier;

    public function __construct(
        private readonly EmailVerifyDto $dto,
    ) {}

    /**
     * Step 1: 產生驗證碼 + 存 Cache + 寄信 + 產生 uuid
     * @throws ControllerException|RandomException
     */
    public function send_code(): self
    {
        $this->_check_rate_limit();

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->generatedUuid = (string) Str::uuid();

        Cache::put(
            self::VERIFICATION_PREFIX . $this->generatedUuid,
            [
                'email' => $this->dto->email,
                'code' => $verificationCode,
                'created_at' => now()->toDateTimeString(),
            ],
            now()->addMinutes(self::VERIFICATION_EXPIRE_MINUTES)
        );

        $this->_send_email($verificationCode);

        // 設定頻率限制
        Cache::put(
            self::RATE_LIMIT_PREFIX . $this->dto->email,
            true,
            now()->addMinutes(self::RATE_LIMIT_MINUTES)
        );

        return $this;
    }

    /**
     * 驗證流程
     * - 有 code（Step 2）：比對驗證碼，存已驗證狀態
     * - 無 code（Step 3）：從已驗證的 cache 取回 email
     * @throws ControllerException
     */
    public function verify(?string $code = null): self
    {
        if ($code !== null) {
            $this->_verify_code($code);
        } else {
            $this->_retrieve_verified_email();
        }

        return $this;
    }

    /**
     * 取得識別符（email）
     */
    public function get_identifier(): string
    {
        return $this->identifier;
    }

    /**
     * 取得 uuid（供 controller 回傳前端）
     */
    public function get_uuid(): string
    {
        return $this->generatedUuid;
    }

    /**
     * Step 2: 比對驗證碼
     * @throws ControllerException
     */
    private function _verify_code(string $code): void
    {
        $cacheKey = self::VERIFICATION_PREFIX . $this->dto->uuid;
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData || $cachedData['code'] !== $code) {
            throw new ControllerException('驗證碼錯誤或已過期');
        }

        $this->identifier = $cachedData['email'];

        // 儲存已驗證狀態（加密 email）
        Cache::put(
            self::VERIFIED_PREFIX . $this->dto->uuid,
            [
                'encrypted_email' => encrypt($this->identifier),
                'created_at' => now()->toDateTimeString(),
            ],
            now()->addMinutes(self::VERIFIED_EXPIRE_MINUTES)
        );

        // 清除驗證碼 cache
        Cache::forget($cacheKey);
    }

    /**
     * Step 3: 從已驗證的 cache 取回 email
     * @throws ControllerException
     */
    private function _retrieve_verified_email(): void
    {
        $cacheKey = self::VERIFIED_PREFIX . $this->dto->uuid;
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            throw new ControllerException('驗證資訊無效或已過期');
        }

        $this->identifier = decrypt($cachedData['encrypted_email']);

        // 清除已驗證 cache（一次性使用）
        Cache::forget($cacheKey);
    }

    /**
     * 發送驗證碼 Email
     * @throws ControllerException
     */
    private function _send_email(string $verificationCode): void
    {
        try {
            // cache 放空資料，強制使用 config 中的 host，不抓取線上版本
            Cache::put('data_api_system_list', collect([]), now()->addMinutes(1));

            CrossFacade::fetch(
                new CrossNotificationDto(
                    system: 'n8n',
                    token: $this->_generate_temporary_jwt_token(),
                    platform: Platform::Email,
                    payload: (new EmailPayloadDto(
                        receiver: [$this->dto->email],
                        title: '會員重設密碼驗證信件',
                        content: $this->_render_email_content($verificationCode),
                    ))->get()
                )
            );
        } catch (Throwable $e) {
            throw new ControllerException('Email 發送失敗: ' . $e->getMessage());
        }
    }

    /**
     * 渲染信件 HTML
     */
    private function _render_email_content(string $verificationCode): string
    {
        return View::make('emails.member_reset_password_verification', [
            'verificationCode' => $verificationCode,
        ])->render();
    }

    /**
     * 產生臨時 JWT token（CrossFacade 需要）
     */
    private function _generate_temporary_jwt_token(): string
    {
        $key = config('app.jwt_secret');
        $issuedAt = time();
        $expireAt = $issuedAt + (self::TEMP_JWT_EXPIRE_MINUTES * 60);

        return JWT::encode([
            'iat' => $issuedAt,
            'exp' => $expireAt,
            'sub' => 'email_verification',
            'jti' => (string) Str::uuid(),
        ], $key, 'HS256');
    }

    /**
     * 頻率限制檢查
     * @throws ControllerException
     */
    private function _check_rate_limit(): void
    {
        if (Cache::has(self::RATE_LIMIT_PREFIX . $this->dto->email)) {
            throw new ControllerException('發送過於頻繁，請稍後再試');
        }
    }
}
