<?php

namespace App\Services\MemberAccount;

use App\Core\Enums\MemberAccount\AccountType;
use App\Core\Services\MemberAccount\Contracts\MemberAccountContract;
use App\Core\Services\MemberAccount\Dtos\EmailVerifyDto;
use App\Core\Services\MemberAccount\Dtos\PhoneVerifyDto;
use App\Services\MemberAccount\Action\EmailVerifyProcess;
use App\Services\MemberAccount\Action\PhoneVerifyProcess;
use App\Services\MemberAccount\Action\MemberDataPrepareProcess;
use App\Services\Service;
use Jsadways\LaravelSDK\Exceptions\ServiceException;

class MemberAccountService extends Service implements MemberAccountContract
{
    /**
     * 開始手機驗證流程
     */
    public function phone_verify(PhoneVerifyDto $dto): PhoneVerifyProcess
    {
        return new PhoneVerifyProcess(dto: $dto);
    }

    /**
     * 開始 Email 驗證流程
     */
    public function email_verify(EmailVerifyDto $dto): EmailVerifyProcess
    {
        return new EmailVerifyProcess(dto: $dto);
    }

    /**
     * 開始會員資料準備流程
     */
    public function member_prepare(string $password): MemberDataPrepareProcess
    {
        return new MemberDataPrepareProcess(
            password: $password
        );
    }

    /**
     * 檢測帳號類型
     * @throws ServiceException
     */
    public function detect_account_type(string $account): AccountType
    {
        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
            return AccountType::EMAIL;
        }

        if (preg_match('/^09\d{8}$/', $account)) {
            return AccountType::PHONE;
        }

        throw new ServiceException('帳號格式不正確，請使用有效的 Email 或手機號碼');
    }

    /**
     * 驗證手機號碼格式
     * @throws ServiceException
     */
    public function validate_phone_format(string $account): void
    {
        if (!preg_match('/^09\d{8}$/', $account)) {
            throw new ServiceException('手機號碼格式不正確');
        }
    }

    /**
     * 驗證 Email 格式
     * @throws ServiceException
     */
    public function validate_email_format(string $account): void
    {
        if (!filter_var($account, FILTER_VALIDATE_EMAIL)) {
            throw new ServiceException('Email 格式不正確');
        }
    }
}
