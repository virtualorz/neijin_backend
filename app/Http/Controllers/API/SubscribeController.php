<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Subscribe\SubscribeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Js\Authenticator\Facades\UserFacade;
use Jsadways\LaravelSDK\Exceptions\RepositoryException;
use Jsadways\LaravelSDK\Exceptions\ServiceException;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

class SubscribeController extends Controller
{
    public function __construct(
        private readonly SubscribeService $subscribe_service,
    ){}

    /**
     * 統一的訂閱動作端點
     *
     * @throws ServiceException|RepositoryException
     */
    public function subscribe(ServerRequest $request): JsonResponse
    {
        $payload = $request->validate([
            'action' => 'required|string|in:subscribe,switch,cancel',
            'subscription_plan_id' => 'nullable|integer',
        ]);

        $user_id = (int) UserFacade::get_user()['id'];
        $action  = $payload['action'];
        $plan_id = $payload['subscription_plan_id'] ?? null;

        // 1. Repository 預先取資料
        $current_active = $this->repository('Subscription')->get_active_by_user($user_id);
        $plan = $plan_id
            ? $this->repository('SubscriptionPlan')->read_model([
                'id_eq' => $plan_id,
                'is_active_eq' => true,
            ])
            : null;

        // 2. Service 計算要做什麼（純邏輯）
        $execution_plan = $this->subscribe_service
            ->set_context($user_id, $action, $current_active, $plan)
            ->verify()
            ->get_execute_plan();

        // 3. Controller 在 transaction 內持久化
        $result = DB::transaction(function () use ($execution_plan) {
            $subscription = null;

            // 取消舊訂閱
            if ($execution_plan['cancel_id']) {
                $subscription = $this->repository('Subscription')->cancel($execution_plan['cancel_id']);
            }

            // 建立新訂閱（會覆蓋上面的 cancelled，因為新訂閱才是用戶當前狀態）
            if ($execution_plan['create']) {
                $subscription = $this->repository('Subscription')->create($execution_plan['create']);
            }

            return $subscription;
        });

        return response()->json(['data' => $result]);
    }
}
