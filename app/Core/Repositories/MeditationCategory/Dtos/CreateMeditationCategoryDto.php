<?php

namespace App\Core\Repositories\MeditationCategory\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateMeditationCategoryDto extends Dto
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?array $icon,
        public readonly string $sort_order,
        public readonly array $create_meditation_list = [],
        public readonly array $create_meditation_list = []
    )
    {
    }
}