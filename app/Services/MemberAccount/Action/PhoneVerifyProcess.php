<?php

namespace App\Services\MemberAccount\Action;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class PhoneVerifyProcess
{
    private string $phone;
    private ?string $code;
    private ?string $uuid = null;

    public function __construct(string $phone, ?string $code = null)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    /**
     * Send verification code via Twilio Verify
     */
    public function send_code(): self
    {
        // Rate limit: 1 minute per phone
        $rateLimitKey = "PHONE_RATE_LIMIT_{$this->phone}";
        if (Cache::has($rateLimitKey)) {
            throw new \Exception('請稍候再試，每分鐘僅能發送一次驗證碼');
        }

        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );

        // Convert Taiwan phone format: 09xx -> +886xx
        $internationalPhone = '+886' . substr($this->phone, 1);

        $twilio->verify->v2
            ->services(config('services.twilio.verify_service_sid'))
            ->verifications
            ->create($internationalPhone, 'sms');

        // Set rate limit for 1 minute
        Cache::put($rateLimitKey, true, 60);

        return $this;
    }

    /**
     * Verify the code via Twilio Verify
     */
    public function verify(): self
    {
        if ($this->code) {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.auth_token')
            );

            $internationalPhone = '+886' . substr($this->phone, 1);

            $verification = $twilio->verify->v2
                ->services(config('services.twilio.verify_service_sid'))
                ->verificationChecks
                ->create([
                    'to' => $internationalPhone,
                    'code' => $this->code,
                ]);

            if ($verification->status !== 'approved') {
                throw new \Exception('驗證碼錯誤或已過期');
            }

            // Store verified phone in cache with UUID
            $this->uuid = Str::uuid()->toString();
            Cache::put(
                "PHONE_VERIFIED_{$this->uuid}",
                encrypt($this->phone),
                now()->addMinutes(30)
            );
        } else {
            // Retrieve from cache (for multi-step flows)
            if (!$this->uuid || !Cache::has("PHONE_VERIFIED_{$this->uuid}")) {
                throw new \Exception('驗證已過期，請重新驗證');
            }
        }

        return $this;
    }

    /**
     * Get the verified phone number from cache
     */
    public static function get_identifier(string $uuid): string
    {
        $cached = Cache::get("PHONE_VERIFIED_{$uuid}");
        if (!$cached) {
            throw new \Exception('驗證已過期，請重新驗證');
        }
        return decrypt($cached);
    }

    /**
     * Get the UUID
     */
    public function get_uuid(): string
    {
        return $this->uuid;
    }
}
