<?php

namespace App\Core\Repositories\BreathingPattern\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateBreathingPatternDto extends Dto
{
    public function __construct(
        public readonly string $name,
        public readonly string $inhale_seconds,
        public readonly string $hold_seconds,
        public readonly string $exhale_seconds,
        public readonly string $hold_after_exhale_seconds,
        public readonly ?string $description,
        public readonly string $sort_order
    )
    {
    }
}