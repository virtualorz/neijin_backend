<?php

namespace App\Core\Services\MemberAccount\Dtos;

class EmailVerifyDto
{
    public function __construct(
        public readonly ?string $email = null,
        public readonly ?string $uuid = null,
    ) {}
}
