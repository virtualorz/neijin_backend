<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Auth extends AuthModel implements JWTSubject
{


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
            'phone_verified_at' => 'datetime',
            'daily_reminder' => 'boolean',
            'reminder_meditation' => 'boolean',
            'reminder_emotion' => 'boolean',
            'password' => 'hashed',
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
}
