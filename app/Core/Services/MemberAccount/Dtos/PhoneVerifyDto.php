<?php

namespace App\Core\Services\MemberAccount\Dtos;

class PhoneVerifyDto
{
    public function __construct(
        public readonly string $token,
        public readonly ?string $password = null,
        public readonly ?string $promote_by = null,
    ) {}
}
