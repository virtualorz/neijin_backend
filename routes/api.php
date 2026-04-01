<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberRegistrationController;
use App\Http\Controllers\Api\MemberResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MeditationCategoryController;
use App\Http\Controllers\MeditationController;
use App\Http\Controllers\SleepStoryController;
use App\Http\Controllers\WhiteNoiseController;
use App\Http\Controllers\BreathingPatternController;
use App\Http\Controllers\EmotionLogController;
use App\Http\Controllers\UserMeditationHistoryController;
use App\Http\Controllers\PersonalAccessTokenController;
use Illuminate\Support\Facades\Route;

// Public routes (no auth required)

// Auth
Route::post('/login', [AuthController::class, 'login']);

// Registration
Route::post('/member-registration/pre-check', [MemberRegistrationController::class, 'pre_check']);
Route::post('/member-registration/send-verification-code', [MemberRegistrationController::class, 'send_verification_code']);
Route::post('/member-registration/verify-code', [MemberRegistrationController::class, 'verify_code']);
Route::post('/member-registration/register', [MemberRegistrationController::class, 'register']);

// Password Reset
Route::post('/member-password-reset/pre-check', [MemberResetPasswordController::class, 'pre_check']);
Route::post('/member-password-reset/send-verification-code', [MemberResetPasswordController::class, 'send_verification_code']);
Route::post('/member-password-reset/verify-code', [MemberResetPasswordController::class, 'verify_code']);
Route::post('/member-password-reset/reset-password', [MemberResetPasswordController::class, 'reset_password']);

Route::middleware(['js-authenticate-middleware-alias'])->group(function () {

// Auth (requires login)
Route::post('/login_info', [AuthController::class, 'login_info']);
Route::post('/logout', [AuthController::class, 'logout']);

// User routes
Route::prefix('users')->controller(UserController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// SubscriptionPlan routes
Route::prefix('subscription-plans')->controller(SubscriptionPlanController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// Subscription routes
Route::prefix('subscriptions')->controller(SubscriptionController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// MeditationCategory routes
Route::prefix('meditation-categories')->controller(MeditationCategoryController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// Meditation routes
Route::prefix('meditations')->controller(MeditationController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// SleepStory routes
Route::prefix('sleep-stories')->controller(SleepStoryController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// WhiteNoise routes
Route::prefix('white-noises')->controller(WhiteNoiseController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// BreathingPattern routes
Route::prefix('breathing-patterns')->controller(BreathingPatternController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// EmotionLog routes
Route::prefix('emotion-logs')->controller(EmotionLogController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// UserMeditationHistory routes
Route::prefix('user-meditation-histories')->controller(UserMeditationHistoryController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

// PersonalAccessToken routes
Route::prefix('personal-access-tokens')->controller(PersonalAccessTokenController::class)->group(function() {
    Route::get('/', 'read_list');
    Route::post('/', 'create');
    Route::put('/', 'update');
});

});
