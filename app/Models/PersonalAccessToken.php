<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalAccessToken extends Model
{


    protected $table = 'personal_access_tokens';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'tokenable' => 'required',
            'name' => 'required|string',
            'token' => 'required|string|max:64',
            'abilities' => 'nullable|string',
            'last_used_at' => 'nullable|datetime',
            'expires_at' => 'nullable|datetime'
        ];
    }

}