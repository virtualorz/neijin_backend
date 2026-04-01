<?php

namespace App\Core\Repositories\User\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdatePreferencesDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $theme,
        public readonly string $font_size,
    )
    {
    }
}
