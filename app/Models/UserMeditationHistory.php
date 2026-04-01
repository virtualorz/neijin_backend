<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMeditationHistory extends Model
{
    use SoftDeletes;

    protected $table = 'user_meditation_history';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'user_id' => 'required|integer',
            'playable' => 'required',
            'duration_seconds' => 'nullable',
            'completed' => 'required|bool',
            'played_date' => 'required|date'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}