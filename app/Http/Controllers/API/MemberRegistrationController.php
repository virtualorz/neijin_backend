<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MemberAccount\Action\PhoneVerifyProcess;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

class MemberRegistrationController extends Controller
{
    /**
     * Step 1: Pre-check if phone is available
     */
    public function pre_check(ServerRequest $request): array
    {
        $payload = $request->validate([
            'phone' => 'required|string',
        ]);

        if (!preg_match('/^09\d{8}$/', $payload['phone'])) {
            throw new \Exception('手機號碼格式錯誤');
        }

        if (User::where('phone', $payload['phone'])->exists()) {
            throw new \Exception('此手機號碼已註冊');
        }

        return ['success' => true];
    }

    /**
     * Step 2: Send SMS verification code
     */
    public function send_verification_code(ServerRequest $request): array
    {
        $payload = $request->validate([
            'phone' => 'required|string',
        ]);

        if (!preg_match('/^09\d{8}$/', $payload['phone'])) {
            throw new \Exception('手機號碼格式錯誤');
        }

        $process = new PhoneVerifyProcess($payload['phone']);
        $process->send_code();

        return ['success' => true];
    }

    /**
     * Step 3: Verify code, return UUID
     */
    public function verify_code(ServerRequest $request): array
    {
        $payload = $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
        ]);

        $process = new PhoneVerifyProcess($payload['phone'], $payload['code']);
        $process->verify();

        return ['uuid' => $process->get_uuid()];
    }

    /**
     * Step 4: Register with UUID + password + name
     */
    public function register(ServerRequest $request): array
    {
        $payload = $request->validate([
            'uuid' => 'required|string',
            'password' => 'required|string|min:6',
            'name' => 'nullable|string|max:50',
        ]);

        $phone = PhoneVerifyProcess::get_identifier($payload['uuid']);

        if (User::where('phone', $phone)->exists()) {
            throw new \Exception('此手機號碼已註冊');
        }

        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($payload['password']),
            'name' => $payload['name'] ?? null,
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
