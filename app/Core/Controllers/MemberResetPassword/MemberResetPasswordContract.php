<?php

namespace App\Core\Controllers\MemberResetPassword;

use Illuminate\Http\Request;

interface MemberResetPasswordContract
{
    public function pre_check(Request $request): array;

    public function send_verification_code(Request $request): array;

    public function verify_code(Request $request): array;

    public function reset_password(Request $request): array;
}
