<?php

namespace App\Core\Services\Auth\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

final class AuthDto extends Dto
{
    public function __construct(
        public readonly string $token,
    )
    {

    }
}
