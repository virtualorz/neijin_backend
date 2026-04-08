<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository extends Repository
{
    protected array $__read_relations__ = ['user', 'subscription_plan'];

    /**
     * 取得用戶當前有效的訂閱（active 且未過期）
     */
    public function get_active_by_user(int $user_id): ?Subscription
    {
        return Subscription::where('user_id', $user_id)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->first();
    }

    /**
     * 取消指定訂閱（status -> cancelled, cancelled_at -> now）
     *
     * 註：使用自定義方法而非 SDK 的 update(Dto)，因為「取消」是有業務語意的動作，
     * 且只更新兩個欄位，不需要組裝完整的 UpdateSubscriptionDto
     */
    public function cancel(int $id): ?Subscription
    {
        $sub = Subscription::find($id);
        if (!$sub) {
            return null;
        }
        $sub->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);
        return $sub->fresh();
    }
}
