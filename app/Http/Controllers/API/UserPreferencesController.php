<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Js\Authenticator\Facades\UserFacade;

class UserPreferencesController extends BaseController
{
    public function update(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,medium,large',
        ]);

        $token = UserFacade::get_token();
        $loginData = cache()->get('LOGIN_' . $token);
        $userId = $loginData['user']['user']['id'];

        $user = User::findOrFail($userId);
        $user->update($payload);

        return response()->json(['success' => true]);
    }
}
