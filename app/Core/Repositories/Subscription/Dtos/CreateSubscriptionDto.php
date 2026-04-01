<?php

namespace App\Core\Repositories\Subscription\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class CreateSubscriptionDto extends Dto
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $user_id,
        public readonly int $subscription_plan_id,
        public readonly int $subscription_plan_id,
        public readonly string $status,
        public readonly ?string $payment_provider,
        public readonly ?string $payment_provider_id,
        public readonly string $starts_at,
        public readonly string $ends_at,
        public readonly ?string $cancelled_at
    )
    {
    }
}