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

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:30',
            'icon' => 'nullable|array',
            'sort_order' => 'required'
        ];
    }

    public function meditation_list(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Meditation::class, 'meditation_category', 'meditation_category_id', 'meditation_id');
    }
}