<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeditationCategory extends Model
{


    protected $table = 'meditation_categories';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected array $file_columns = ['icon'];

    protected function casts(): array
    {
        return [
            'icon' => 'array',
        ];
    }

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:30',
            'icon' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail('The ' . $attribute . ' must be a string or array.');
                    }
                }
            ],
            'sort_order' => 'required'
        ];
    }

    public function meditation_list(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Meditation::class, 'meditation_category', 'meditation_category_id', 'meditation_id');
    }
}