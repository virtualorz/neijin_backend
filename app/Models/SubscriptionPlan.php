<?php

namespace App\Models;

use App\Core\Enums\BillingCycle;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected function _schema(): array
    {
        return [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:30',
            'billing_cycle' => 'required|in:monthly,yearly',
            'price' => 'required|integer',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'required|boolean',
            'sort_order' => 'required|integer',
        ];
    }

    protected function casts(): array
    {
        return [
            'billing_cycle' => BillingCycle::class,
            'features' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function subscription_list(): HasMany
    {
        return $this->hasMany(Subscription::class, 'subscription_plan_id', 'id');
    }
}
