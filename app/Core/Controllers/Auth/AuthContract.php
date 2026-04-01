<?php

namespace App\Core\Controllers\Auth;

use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

interface AuthContract{
    public function login(ServerRequest $request):string;
    public function login_info(ServerRequest $request):array;

    public function logout(ServerRequest $request):void;
}
