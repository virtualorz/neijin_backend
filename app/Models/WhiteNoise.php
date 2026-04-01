<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhiteNoise extends Model
{
    use SoftDeletes;

    protected $table = 'white_noises';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'audio' => 'required|array',
            'icon' => 'nullable|array',
            'is_free' => 'required|bool',
            'is_published' => 'required|bool',
            'sort_order' => 'required'
        ];
    }

}