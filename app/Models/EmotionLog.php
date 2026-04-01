<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmotionLog extends Model
{
    use SoftDeletes;

    protected $table = 'emotion_logs';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'user_id' => 'required|integer',
            'score' => 'required',
            'logged_date' => 'required|date',
            'note' => 'nullable|string'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}