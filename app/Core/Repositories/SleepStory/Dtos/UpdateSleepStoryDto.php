<?php

namespace App\Core\Repositories\SleepStory\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateSleepStoryDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $duration_minutes,
        public readonly array $audio,
        public readonly ?array $cover_image,
        public readonly ?array $background_music,
        public readonly bool $is_free,
        public readonly bool $is_published,
        public readonly string $sort_order
    )
    {
    }
}