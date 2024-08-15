<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\StoreLikeRequest;
use App\Http\Requests\Like\UpdateLikeRequest;
use App\Models\Like;
use App\Services\LikeService;
use App\Services\NotificationService;

class LikeController extends Controller
{
    protected  likeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
        $this->middleware(['auth:api'])->only('like');
    }

    public function like(StoreLikeRequest $request,NotificationService $notificationService)
    {
        return $this->likeService->like($request->validated(),$notificationService);

    }
}
