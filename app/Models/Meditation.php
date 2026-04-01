<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meditation extends Model
{
    use SoftDeletes;

    protected $table = 'meditations';
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
            'is_free' => 'required|bool',
            'is_published' => 'required|bool',
            'sort_order' => 'required',
            'is_free' => 'required',
            'meditation_id' => 'required|integer',
            'meditation_id' => 'required|integer',
            'meditation_category_id' => 'required|integer',
            'meditation_category_id' => 'required|integer'
        ];
    }

    public function meditation_list(): HasMany
    {
        return $this->hasMany(Meditation::class, 'meditation_id', 'id');
    }

    public function meditation_list(): HasMany
    {
        return $this->hasMany(Meditation::class, 'meditation_id', 'id');
    }

    public function meditation(): BelongsTo
    {
        return $this->belongsTo(Meditation::class, 'meditation_id', 'id');
    }

    public function meditation(): BelongsTo
    {
        return $this->belongsTo(Meditation::class, 'meditation_id', 'id');
    }

    public function meditation_category(): BelongsTo
    {
        return $this->belongsTo(MeditationCategory::class, 'meditation_category_id', 'id');
    }

    public function meditation_category(): BelongsTo
    {
        return $this->belongsTo(MeditationCategory::class, 'meditation_category_id', 'id');
    }
}