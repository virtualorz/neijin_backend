<?php
namespace App\Services\Auth;

use App\Core\Services\Auth\Contracts\AuthContract;
use App\Core\Services\Auth\Dtos\AuthDto;
use App\Services\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Jsadways\LaravelSDK\Exceptions\RepositoryException;
use Jsadways\LaravelSDK\Exceptions\ServiceException;
use Throwable;

class AuthService extends Service implements AuthContract
{
    const TOKEN_CACHE = 'LOGIN_';
    /**
     * @throws ServiceException
     */
    public function verify_account(string $account, string $password): AuthDto
    {
        try {
            $token = Auth::guard('api')->attempt([
                'account' => $account,
                'password' => $password
            ]);

            if (!$token) {
                throw new Exception("account {$account} 登入資訊有錯誤。");
            }

            return new AuthDto(token: $token);
        } catch (RepositoryException $e) {
            throw new ServiceException($e->getMessage());
        } catch (Throwable $e) {
            throw new ServiceException($this->get_error($e));
        }
    }

    public function set_login_data(string $token): bool
    {
        $expiration_time = $this->_gen_expiration_time();
        $user = Auth::guard('api')->user();

        // 更新 last_login 時間戳記
        $user->last_login = now();
        $user->save();

        $user_info = ['user' => $user->load(['active_member_vip_list'])->toArray()];
        $login_info = [
            'expiration_time' => $expiration_time->toDateTimeString(),
            'user' => $user_info
        ];

        Cache::put($token, $user_info, $expiration_time);
        $user_id = $user_info['user']['id'];
        Cache::put("user-{$user_id}", $token, $expiration_time);

        return Cache::put(self::TOKEN_CACHE.$token, $login_info, $expiration_time);
    }

    /**
     * @throws ServiceException
     */
    public function get_login_data(string $token): array
    {
        if(Cache::has(self::TOKEN_CACHE.$token)){
            return Cache::get(self::TOKEN_CACHE.$token);
        }

        throw new ServiceException('登入已過期');
    }

    public function remove_login_data(string $token):void
    {
        $login_info = Cache::get(self::TOKEN_CACHE.$token);
        $user_info = $login_info['user'];
        $user_id = $user_info['user']['id'];

        Cache::forget($token);
        Cache::forget("user-{$user_id}");
        Cache::forget(self::TOKEN_CACHE.$token);
    }

    protected function _gen_expiration_time(): Carbon
    {
        return now()->addMinutes(config('js_auth.expiration_time'));
    }
}
