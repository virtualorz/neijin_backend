<?php

namespace App\Models;

class MeditationCategoryPivot extends Model
{
    protected $table = 'meditation_category';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected function _schema(): array
    {
        return [
            'meditation_id' => 'required|integer',
            'meditation_category_id' => 'required|integer',
        ];
    }
}
