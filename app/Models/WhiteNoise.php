<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhiteNoise extends Model
{
    protected $table = 'white_noises';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected array $file_columns = ['audio', 'icon'];
    protected $appends = ['audio_url', 'icon_url'];

    public function getAudioUrlAttribute(): ?string
    {
        return $this->getSignedUrl($this->audio);
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->getSignedUrl($this->icon);
    }

    protected function casts(): array
    {
        return [
            'audio' => 'array',
            'icon' => 'array',
        ];
    }

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'audio' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail('The ' . $attribute . ' must be a string or array.');
                    }
                }
            ],
            'icon' => [
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
}
