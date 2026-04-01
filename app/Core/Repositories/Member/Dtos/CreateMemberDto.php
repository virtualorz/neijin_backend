<?php

namespace App\Core\Repositories\Member\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateMemberDto extends Dto
{
    public function __construct(
        public readonly bool $is_manager,
        public readonly string $account,
        public readonly string $password,
        public readonly string $cellphone,
        public readonly bool $enable_sms_remind,
        public readonly bool $enable_delete_baby,
        public readonly bool $is_enable,
        public readonly string $promote_code,
        public readonly int $promote_point_rate,
        public readonly ?string $name = null,
        public readonly ?int $age = null,
        public readonly ?string $gender = null,
        public readonly ?array $photo = null,
        public readonly ?string $tel = null,
        public readonly ?string $email = null,
        public readonly ?int $address_city = null,
        public readonly ?int $address_town = null,
        public readonly ?string $address = null,
        public readonly ?string $self_description = null,
        public readonly ?string $promote_by = null,
        public readonly ?string $last_login = null,
        public readonly array $create_member_point_list = [],
        public readonly array $create_member_vip_list = []
    )
    {
    }
}
