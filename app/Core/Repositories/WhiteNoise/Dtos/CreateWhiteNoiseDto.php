<?php

namespace App\Core\Repositories\WhiteNoise\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateWhiteNoiseDto extends Dto
{
    public function __construct(
        public readonly string $name,
        public readonly array $audio,
        public readonly ?array $icon,
        public readonly bool $is_free,
        public readonly bool $is_published,
        public readonly string $sort_order
    )
    {
    }
}