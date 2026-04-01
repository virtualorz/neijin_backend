<?php

namespace App\Models;

use App\Core\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'user_id' => 'required|integer',
            'subscription_plan_id' => 'required|integer',
            'status' => 'required|in:active,cancelled,expired,past_due',
            'payment_provider' => 'nullable|string|max:30',
            'payment_provider_id' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'cancelled_at' => 'nullable|date',
        ];
    }

    protected function casts(): array
    {
        return [
            'status' => SubscriptionStatus::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subscription_plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id', 'id');
    }
}
