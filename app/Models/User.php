<?php

namespace App\Models;

use App\Core\Enums\FontSize;
use App\Core\Enums\Membership;
use App\Core\Enums\Theme;
use App\Core\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends AuthModel implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $hidden = [
        'password',
    ];

    protected function _schema(): array
    {
        return [
            'phone' => 'required|string|max:20|unique:users,phone',
            'role' => 'required|in:user,admin',
            'password' => 'required|string',
            'name' => 'nullable|string|max:50',
            'avatar' => 'nullable|array',
            'membership' => 'required|in:free,premium',
            'phone_verified_at' => 'nullable|date',
            'daily_reminder' => 'required|boolean',
            'reminder_time' => 'nullable',
            'reminder_meditation' => 'required|boolean',
            'reminder_emotion' => 'required|boolean',
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,medium,large',
        ];
    }

    protected function casts(): array
    {
        return [
            'avatar' => 'array',
            'role' => UserRole::class,
            'membership' => Membership::class,
            'theme' => Theme::class,
            'font_size' => FontSize::class,
            'phone_verified_at' => 'datetime',
            'daily_reminder' => 'boolean',
            'reminder_meditation' => 'boolean',
            'reminder_emotion' => 'boolean',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function subscription_list(): HasMany
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    public function emotion_log_list(): HasMany
    {
        return $this->hasMany(EmotionLog::class, 'user_id', 'id');
    }

    public function user_meditation_history_list(): HasMany
    {
        return $this->hasMany(UserMeditationHistory::class, 'user_id', 'id');
    }
}
