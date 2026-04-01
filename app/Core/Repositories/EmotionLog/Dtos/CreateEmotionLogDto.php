<?php

namespace App\Core\Repositories\EmotionLog\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateEmotionLogDto extends Dto
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $user_id,
        public readonly string $score,
        public readonly string $logged_date,
        public readonly ?string $note
    )
    {
    }
}