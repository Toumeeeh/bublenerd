<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use App\Models\Subscription;
use function Symfony\Component\String\s;

class SubscriptionController extends Controller
{

    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService= $subscriptionService;
        $this->middleware(['auth:api'])->only('Subscription');

    }
    public function Subscription(StoreSubscriptionRequest $data)
    {

     return $this->subscriptionService->Subscription($data->safe()->all());

    }

}
