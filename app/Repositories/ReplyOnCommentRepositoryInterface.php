<?php

namespace App\Repositories;

use App\Services\NotificationService;

interface ReplyOnCommentRepositoryInterface
{
    public function index();
    public function getById(int $id);
    public function create(array $data,NotificationService $notificationService);
    public function delete(int $id);
    public function getReplyOnComment(int $id);
}
