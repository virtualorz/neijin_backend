<?php

namespace App\Services\MemberAccount\Action;

use App\Core\Repositories\Member\Dtos\UpdateMemberDto;

class MemberDataPrepareProcess
{
    public function __construct(
        private readonly string $password,
    ) {}

    /**
     * 根據現有會員資料組裝更新密碼用的 UpdateMemberDto
     */
    public function create_update_password_data(array $member): UpdateMemberDto
    {
        unset(
            $member['created_at'],
            $member['updated_at'],
            $member['deleted_at'],
            $member['member_evaluate_list'],
            $member['member_point_list'],
            $member['member_vip_list'],
            $member['active_member_vip_list'],
            $member['member_rescue_list'],
        );

        $member['password'] = $this->password;

        return new UpdateMemberDto(...$member);
    }
}
