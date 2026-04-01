<?php

namespace App\Core\Controllers\MemberRegistration;

use Illuminate\Http\Request;

interface MemberRegistrationContract
{
    public function pre_check(Request $request): array;

    public function send_verification_code(Request $request): array;

    public function verify_code(Request $request): array;

    public function register(Request $request): array;
}
