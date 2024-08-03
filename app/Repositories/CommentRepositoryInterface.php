<?php

namespace App\Repositories;

use App\Services\NotificationService;

interface CommentRepositoryInterface
{
    public function index();
    public function getById(int $id);
    public function create(array $data,NotificationService $notificationService);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function getLessonWithComment(int $id);
}
