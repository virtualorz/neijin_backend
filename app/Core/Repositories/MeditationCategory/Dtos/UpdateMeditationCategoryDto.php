<?php

namespace App\Core\Repositories\MeditationCategory\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateMeditationCategoryDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?array $icon,
        public readonly string $sort_order,
        public readonly array $create_meditation_list = [],
        public readonly array $update_meditation_list = [],
        public readonly array $delete_meditation_list = [],
        public readonly array $create_meditation_list = [],
        public readonly array $update_meditation_list = [],
        public readonly array $delete_meditation_list = []
    )
    {
    }
}