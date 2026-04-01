<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MemberAccount\Action\PhoneVerifyProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberResetPasswordController extends Controller
{
    /**
     * Step 1: Check if phone exists
     * POST /member-password-reset/pre-check
     */
    public function pre_check(Request $request): array
    {
        $phone = $request->input('phone');

        if (!preg_match('/^09\d{8}$/', $phone)) {
            throw new \Exception('手機號碼格式錯誤');
        }

        if (!User::where('phone', $phone)->exists()) {
            throw new \Exception('此手機號碼尚未註冊');
        }

        return ['success' => true];
    }

    /**
     * Step 2: Send verification code
     * POST /member-password-reset/send-verification-code
     */
    public function send_verification_code(Request $request): array
    {
        $phone = $request->input('phone');

        if (!preg_match('/^09\d{8}$/', $phone)) {
            throw new \Exception('手機號碼格式錯誤');
        }

        $process = new PhoneVerifyProcess($phone);
        $process->send_code();

        return ['success' => true];
    }

    /**
     * Step 3: Verify code
     * POST /member-password-reset/verify-code
     */
    public function verify_code(Request $request): array
    {
        $phone = $request->input('phone');
        $code = $request->input('code');

        $process = new PhoneVerifyProcess($phone, $code);
        $process->verify();

        return ['uuid' => $process->get_uuid()];
    }

    /**
     * Step 4: Reset password
     * POST /member-password-reset/reset-password
     */
    public function reset_password(Request $request): array
    {
        $uuid = $request->input('uuid');
        $password = $request->input('password');

        $phone = PhoneVerifyProcess::get_identifier($uuid);

        $user = User::where('phone', $phone)->firstOrFail();
        $user->password = Hash::make($password);
        $user->save();

        return ['success' => true];
    }
}
