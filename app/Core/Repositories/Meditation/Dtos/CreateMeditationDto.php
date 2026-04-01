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
        public readonly string $is_free,
        public readonly int $meditation_id,
        public readonly int $meditation_id,
        public readonly int $meditation_category_id,
        public readonly int $meditation_category_id,
        public readonly array $create_meditation_list = [],
        public readonly array $create_meditation_list = []
    )
    {
    }
}