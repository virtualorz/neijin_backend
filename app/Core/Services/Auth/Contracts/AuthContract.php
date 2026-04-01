<?php
namespace App\Core\Services\Auth\Contracts;

use App\Core\Services\Auth\Dtos\AuthDto;
use App\Core\Services\Auth\Dtos\LoginDataDto;

interface AuthContract
{
    public function verify_account(string $account, string $password):AuthDto;
    public function set_login_data(string $token):bool;

    public function remove_login_data(string $token):void;
}
