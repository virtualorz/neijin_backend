<?php

namespace App\Core\Repositories\UserMeditationHistory\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateUserMeditationHistoryDto extends Dto
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $user_id,
        public readonly string $playable,
        public readonly ?string $duration_seconds,
        public readonly bool $completed,
        public readonly string $played_date
    )
    {
    }
}