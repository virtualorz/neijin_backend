<?php

namespace App\Core\Repositories\WhiteNoise\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateWhiteNoiseDto extends Dto
{
    public function __construct(
        public readonly int $id,
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