<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Repositories\ReplyOnCommentRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class ReplyOnCommentService
{
    use ResponseTrait;

    protected ReplyOnCommentRepositoryInterface $ReplyOnCommentRepository;

    public function __construct(ReplyOnCommentRepositoryInterface $ReplyOnCommentRepository)
    {
        $this->ReplyOnCommentRepository = $ReplyOnCommentRepository;
    }
    public function index(){
        $data = $this->ReplyOnCommentRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }

    public function getById(int $id)
    {
        try {
            $data = $this->ReplyOnCommentRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getReplyOnComment(int $id)
    {
        try {
            $data = $this->ReplyOnCommentRepository->getReplyOnComment($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function create( array $data,NotificationService $notificationService)
    {
        try {

            $ReplyOnComment = $this->ReplyOnCommentRepository->create(Arr::only($data,[ 'reply','comment_id','user_id']),$notificationService);

            return $this->successWithData($ReplyOnComment, 'created successfully',201);
        }catch (FailedException$e) {
            return $this->failed($e->getMessage(), 400);}
    }


    public function delete(int $id)
    {
        try {
            $this->ReplyOnCommentRepository->delete($id);
            return $this->successWithData('','ReplyOnComment deleted successfully',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

}
