<?php

namespace App\Core\Repositories\Meditation\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateMeditationDto extends Dto
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $duration_minutes,
        public readonly array $audio,
        public readonly ?array $cover_image,
        public readonly bool $is_free,
        public readonly bool $is_published,
        public readonly string $sort_order,
        public readonly array $create_meditation_category_list = []
    )
    {
    }
}
