<?php

namespace App\Core\Repositories\Member\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateMemberDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly bool $is_manager,
        public readonly string $account,
        public readonly ?string $password = null,
        public readonly ?string $name,
        public readonly ?int $age,
        public readonly ?string $gender,
        public readonly ?array $photo = null,
        public readonly ?string $tel,
        public readonly string $cellphone,
        public readonly ?string $email,
        public readonly ?int $address_city,
        public readonly ?int $address_town,
        public readonly ?string $address,
        public readonly ?string $self_description,
        public readonly bool $enable_sms_remind,
        public readonly bool $enable_delete_baby,
        public readonly bool $is_enable,
        public readonly string $promote_code,
        public readonly int $promote_point_rate,
        public readonly ?string $promote_by,
        public readonly ?string $last_login,
        public readonly array $create_member_vip_list = [],
        public readonly array $update_member_vip_list = []
    )
    {
    }
}
