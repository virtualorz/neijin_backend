<?php

namespace App\Repositories;

class SubscriptionRepository extends Repository
{
    protected array $__read_relations__ = ['user', 'subscription_plan'];
}
