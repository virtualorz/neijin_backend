<?php

namespace App\Core\Services\MemberAccount\Contracts;

use App\Core\Enums\MemberAccount\AccountType;
use App\Core\Services\MemberAccount\Dtos\EmailVerifyDto;
use App\Core\Services\MemberAccount\Dtos\PhoneVerifyDto;
use App\Services\MemberAccount\Action\EmailVerifyProcess;
use App\Services\MemberAccount\Action\PhoneVerifyProcess;
use App\Services\MemberAccount\Action\MemberDataPrepareProcess;

interface MemberAccountContract
{
    public function phone_verify(PhoneVerifyDto $dto): PhoneVerifyProcess;

    public function email_verify(EmailVerifyDto $dto): EmailVerifyProcess;

    public function member_prepare(string $password): MemberDataPrepareProcess;

    public function detect_account_type(string $account): AccountType;

    public function validate_phone_format(string $account): void;

    public function validate_email_format(string $account): void;
}
