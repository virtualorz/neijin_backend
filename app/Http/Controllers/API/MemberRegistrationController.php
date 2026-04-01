<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MemberAccount\Action\PhoneVerifyProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberRegistrationController extends Controller
{
    /**
     * Step 1: Pre-check if phone is available
     * POST /member-registration/pre-check
     * Body: { phone: string }
     */
    public function pre_check(Request $request): array
    {
        $phone = $request->input('phone');

        // Validate Taiwan phone format
        if (!preg_match('/^09\d{8}$/', $phone)) {
            throw new \Exception('手機號碼格式錯誤');
        }

        // Check if already registered
        if (User::where('phone', $phone)->exists()) {
            throw new \Exception('此手機號碼已註冊');
        }

        return ['success' => true];
    }

    /**
     * Step 2: Send SMS verification code
     * POST /member-registration/send-verification-code
     * Body: { phone: string }
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
     * Step 3: Verify code, return UUID
     * POST /member-registration/verify-code
     * Body: { phone: string, code: string }
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
     * Step 4: Register with UUID + password + name
     * POST /member-registration/register
     * Body: { uuid: string, password: string, name?: string }
     */
    public function register(Request $request): array
    {
        $uuid = $request->input('uuid');
        $password = $request->input('password');
        $name = $request->input('name');

        // Get verified phone from cache
        $phone = PhoneVerifyProcess::get_identifier($uuid);

        // Double check phone not taken
        if (User::where('phone', $phone)->exists()) {
            throw new \Exception('此手機號碼已註冊');
        }

        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($password),
            'name' => $name,
            'membership' => 'free',
            'daily_reminder' => false,
            'reminder_meditation' => true,
            'reminder_emotion' => true,
            'theme' => 'system',
            'font_size' => 'medium',
        ]);

        return ['success' => true, 'user_id' => $user->id];
    }
}
