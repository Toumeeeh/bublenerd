<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyOnComment\StoreReplyOnCommentRequest;
use App\Http\Requests\ReplyOnComment\UpdateReplyOnCommentRequest;
use App\Services\NotificationService;
use App\Services\ReplyOnCommentService;

class ReplyOnCommentController extends Controller
{

    public function __construct(ReplyOnCommentService $ReplyOnCommentService)
    {
        $this->replyoncommentService = $ReplyOnCommentService;

        $this->middleware(['auth:api'])->only(['create','getReplyOnComment','delete']);

    }


    public function index()
    {
        return $this->replyoncommentService->index();
    }


    public function getById(int $id)
    {
        return $this->replyoncommentService->getById($id);
    }

    public function getReplyOnComment(int $id)
    {
        return $this->replyoncommentService->getReplyOnComment($id);
    }

    public function create(StoreReplyOnCommentRequest $data,NotificationService $notificationService)
    {
        return $this->replyoncommentService->create($data->safe()->all(),$notificationService);
    }


    public function delete(int $id)
    {
        return $this->replyoncommentService->delete($id);
    }
}
