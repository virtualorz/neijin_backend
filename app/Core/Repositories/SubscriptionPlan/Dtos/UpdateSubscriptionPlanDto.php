<?php

namespace App\Core\Repositories\SubscriptionPlan\Dtos;

use Jsadways\LaravelSDK\Core\Dto;

class UpdateSubscriptionPlanDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $billing_cycle,
        public readonly string $price,
        public readonly ?string $description,
        public readonly ?array $features,
        public readonly bool $is_active,
        public readonly bool $is_recommended,
        public readonly string $sort_order,
        public readonly array $create_subscription_list = [],
        public readonly array $update_subscription_list = [],
        public readonly array $delete_subscription_list = []
    )
    {
    }
}
