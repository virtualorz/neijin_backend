<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Js\Authenticator\Facades\UserFacade;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

class UserPreferencesController extends BaseController
{
    public function update(ServerRequest $request): JsonResponse
    {
        $payload = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,medium,large',
        ]);

        $user = $this->_get_current_user();
        $user->update($payload);

        return response()->json(['success' => true]);
    }

    public function update_reminders(ServerRequest $request): JsonResponse
    {
        $payload = $request->validate([
            'daily_reminder' => 'required|boolean',
            'reminder_time' => 'nullable|string',
            'reminder_meditation' => 'required|boolean',
            'reminder_emotion' => 'required|boolean',
        ]);

        $user = $this->_get_current_user();
        $user->update($payload);

        return response()->json(['success' => true]);
    }

    private function _get_current_user(): User
    {
        $token = UserFacade::get_token();
        $loginData = cache()->get('LOGIN_' . $token);
        $userId = $loginData['user']['user']['id'];
        return User::findOrFail($userId);
    }
}
