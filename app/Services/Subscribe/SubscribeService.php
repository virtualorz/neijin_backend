<?php

namespace App\Services\Subscribe;

use App\Core\Repositories\Subscription\Dtos\CreateSubscriptionDto;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\Service;
use Jsadways\LaravelSDK\Exceptions\ServiceException;

class SubscribeService extends Service
{
    private const ALLOWED_ACTIONS = ['subscribe', 'switch', 'cancel'];

    private int $user_id;
    private string $action;
    private ?Subscription $current_active = null;
    private ?SubscriptionPlan $plan = null;

    /**
     * Controller 預先把 active 訂閱與目標方案查好後傳入
     *
     * @throws ServiceException
     */
    public function set_context(
        int $user_id,
        string $action,
        ?Subscription $current_active,
        ?SubscriptionPlan $plan
    ): self {
        if (!in_array($action, self::ALLOWED_ACTIONS, true)) {
            throw new ServiceException('不支援的訂閱動作');
        }
        $this->user_id = $user_id;
        $this->action = $action;
        $this->current_active = $current_active;
        $this->plan = $plan;
        return $this;
    }

    /**
     * @throws ServiceException
     */
    public function verify(): self
    {
        match ($this->action) {
            'subscribe' => $this->_verify_subscribe(),
            'switch'    => $this->_verify_switch(),
            'cancel'    => $this->_verify_cancel(),
        };
        return $this;
    }

    /**
     * 計算「要做什麼」並回傳 plan，不執行任何 DB 操作
     *
     * 回傳格式：
     * [
     *   'cancel_id' => int|null,                          // 要取消的訂閱 id
     *   'create'    => CreateSubscriptionDto|null,        // 要建立的訂閱 DTO
     * ]
     */
    public function get_execute_plan(): array
    {
        /**
         * @see self::subscribe()
         * @see self::switch()
         * @see self::cancel()
         */
        return $this->{$this->action}();
    }

    // ============ verify ============

    private function _verify_subscribe(): void
    {
        if (!$this->plan) {
            throw new ServiceException('方案不存在或已停用');
        }
        if ($this->current_active) {
            throw new ServiceException('已有有效訂閱，請使用切換');
        }
    }

    private function _verify_switch(): void
    {
        if (!$this->plan) {
            throw new ServiceException('方案不存在或已停用');
        }
        if (!$this->current_active) {
            throw new ServiceException('沒有有效訂閱可切換');
        }
        if ($this->current_active->subscription_plan_id === $this->plan->id) {
            throw new ServiceException('不能切換到相同方案');
        }
    }

    private function _verify_cancel(): void
    {
        if (!$this->current_active) {
            throw new ServiceException('沒有有效訂閱可取消');
        }
    }

    // ============ action plans ============

    private function subscribe(): array
    {
        return [
            'cancel_id' => null,
            'create'    => $this->_build_create_dto(0),
        ];
    }

    private function switch(): array
    {
        $remaining_days = $this->_get_remaining_days($this->current_active);
        return [
            'cancel_id' => $this->current_active->id,
            'create'    => $this->_build_create_dto($remaining_days),
        ];
    }

    private function cancel(): array
    {
        return [
            'cancel_id' => $this->current_active->id,
            'create'    => null,
        ];
    }

    // ============ helpers ============

    private function _build_create_dto(int $extra_days): CreateSubscriptionDto
    {
        $starts_at = now();
        $ends_at = $this->plan->billing_cycle === 'monthly'
            ? $starts_at->copy()->addMonth()->addDays($extra_days)
            : $starts_at->copy()->addYear()->addDays($extra_days);

        return new CreateSubscriptionDto(
            user_id: $this->user_id,
            subscription_plan_id: $this->plan->id,
            status: 'active',
            payment_provider: null,
            payment_provider_id: null,
            starts_at: $starts_at->toDateTimeString(),
            ends_at: $ends_at->toDateTimeString(),
            cancelled_at: null,
        );
    }

    private function _get_remaining_days(Subscription $sub): int
    {
        $diff = now()->diffInDays($sub->ends_at, false);
        return max(0, (int) ceil($diff));
    }
}
