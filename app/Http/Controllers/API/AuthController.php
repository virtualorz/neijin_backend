<?php

namespace App\Http\Controllers\API;

use App\Core\Controllers\Auth\AuthContract;
use App\Services\Auth\AuthService;
use Js\Authenticator\Facades\UserFacade;
use Jsadways\LaravelSDK\Exceptions\ServiceException;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

readonly class AuthController implements AuthContract
{

    public function __construct(
        private AuthService $AuthService,
    ){}

    /**
     * @throws ServiceException
     */
    public function login(ServerRequest $request):string
    {
        $payload = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string'
        ]);
        $login_result = $this->AuthService->verify_account(...$payload);
        $token = $login_result->get()['token'];

        $this->AuthService->set_login_data(token:$token);

        return $token;
    }

    /**
     * @throws ServiceException
     */
    public function login_info(ServerRequest $request): array
    {
        $token = UserFacade::get_token();
        $user_data = $this->AuthService->get_login_data($token);
        return json_decode(json_encode($user_data), true)['user']['user'];
    }

    public function logout(ServerRequest $request):void
    {
        $token = UserFacade::get_token();
        $this->AuthService->remove_login_data($token);
    }
}
