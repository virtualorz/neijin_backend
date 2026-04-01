<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SleepStory extends Model
{
    use SoftDeletes;

    protected $table = 'sleep_stories';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'duration_minutes' => 'required',
            'audio' => 'required|array',
            'cover_image' => 'nullable|array',
            'background_music' => 'nullable|array',
            'is_free' => 'required|boolean',
            'is_published' => 'required|bool',
            'sort_order' => 'required'
        ];
    }

}