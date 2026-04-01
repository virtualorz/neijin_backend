<?php

namespace App\Core\Repositories\User\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateUserDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $phone,
        public readonly string $role,
        public readonly string $password,
        public readonly ?string $name,
        public readonly ?array $avatar,
        public readonly string $membership,
        public readonly ?string $phone_verified_at,
        public readonly bool $daily_reminder,
        public readonly ?string $reminder_time,
        public readonly bool $reminder_meditation,
        public readonly bool $reminder_emotion,
        public readonly string $theme,
        public readonly string $font_size,
        public readonly array $create_subscription_list = [],
        public readonly array $update_subscription_list = [],
        public readonly array $delete_subscription_list = [],
        public readonly array $create_emotion_log_list = [],
        public readonly array $update_emotion_log_list = [],
        public readonly array $delete_emotion_log_list = [],
        public readonly array $create_user_meditation_history_list = [],
        public readonly array $update_user_meditation_history_list = [],
        public readonly array $delete_user_meditation_history_list = []
    )
    {
    }
}
