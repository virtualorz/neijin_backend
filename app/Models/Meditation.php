<?php

namespace App\Models;

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

    protected array $file_columns = ['audio', 'cover_image'];
    protected $appends = ['audio_url', 'cover_image_url'];

    public function getAudioUrlAttribute(): ?string
    {
        return $this->getSignedUrl($this->audio);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->getSignedUrl($this->cover_image);
    }

    protected function casts(): array
    {
        return [
            'audio' => 'array',
            'cover_image' => 'array',
        ];
    }

    protected function _schema(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'duration_minutes' => 'required',
            'audio' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail('The ' . $attribute . ' must be a string or array.');
                    }
                }
            ],
            'cover_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail('The ' . $attribute . ' must be a string or array.');
                    }
                }
            ],
            'is_free' => 'required|bool',
            'is_published' => 'required|bool',
            'sort_order' => 'required'
        ];
    }

    public function meditation_category_list(): HasMany
    {
        return $this->hasMany(MeditationCategoryPivot::class, 'meditation_id');
    }
}