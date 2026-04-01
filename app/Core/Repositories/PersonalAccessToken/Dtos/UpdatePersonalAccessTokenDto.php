<?php

namespace App\Core\Repositories\PersonalAccessToken\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdatePersonalAccessTokenDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $tokenable,
        public readonly string $name,
        public readonly string $token,
        public readonly ?string $abilities,
        public readonly ?string $last_used_at,
        public readonly ?string $expires_at
    )
    {
    }
}