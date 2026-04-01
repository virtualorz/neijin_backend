<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreathingPattern extends Model
{


    protected $table = 'breathing_patterns';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'inhale_seconds' => 'required',
            'hold_seconds' => 'required',
            'exhale_seconds' => 'required',
            'hold_after_exhale_seconds' => 'required',
            'description' => 'nullable|string',
            'sort_order' => 'required'
        ];
    }

}