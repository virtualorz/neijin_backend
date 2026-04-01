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
            'sort_order' => 'required'
        ];
    }

    public function meditation_category_list(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MeditationCategory::class, 'meditation_category', 'meditation_id', 'meditation_category_id');
    }
}