<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Models\Comment;
use App\Models\Commentable;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Video;
use App\Models\Tag;
use App\Services\NotificationService;
use App\Traits\ResponseTrait;
use App\Traits\StoreVideoTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class CommentRepository implements CommentRepositoryInterface
{
    use ResponseTrait;
    use StoreVideoTrait;

    protected comment $comment;

    public function __construct(comment $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        return $this->comment->get();
    }

    public function getById(int $id)
    {
        $comment = $this->comment->where('id', $id)->get();

        if (!$comment) {
            throw new NotFoundException();
        }
        return $comment;
    }

    public function getLessonWithComment(int $id)
    {
        $lesson = Lesson::with([
            'comments.user:id,name,avatar',
            'comments' => function ($query) {
                $query->withCount('reply');
                $query->withCount('likes');
                $query->with('userLike');

            }
            ])->find($id);

        if (!$lesson) {
            throw new NotFoundException();
        }
        return $lesson;
    }

    public function getVideoWithComment(int $id)
    {
        $video = Video::with([
            'comments.user:id,name,avatar',
            'comments' => function ($query) {
                $query->withCount('reply');
                $query->withCount('likes');
                $query->with('userLike');
            }

        ])->withCount('likes')->find($id);


        if (!$video) {
            throw new NotFoundException();
        }

        return $video;
    }

    public function create(array $data, NotificationService $notificationService)
    {
        try {
            DB::beginTransaction();

            $comment = new Comment();
            $comment->comment = $data['comment'];
            $comment->user_id = Auth::id();
            $comment->save();

            if (isset($data['lesson_id'])) {
                $commentableType = 'App\Models\Lesson';
                $commentableId = $data['lesson_id'];
            }

            if (isset($data['video_id'])) {
                $commentableType = 'App\Models\Video';
                $commentableId = $data['video_id'];
            }

            $commentable = $commentableType::find($commentableId);
            if ($commentable) {
                $commentable->comments()->save($comment);

                if ($commentableType==='App\Models\Lesson')
                      $teacherId = $commentable->course->user_id  ;
                else($teacherId = $commentable->user_id);


                $teacherToken = User::where('id', $teacherId)->pluck('device_token')->first();

                if (!empty($teacherToken)) {
                    $User=$comment->user_id;
                    $notificationBody = $User.'comment on your'.$commentableType;
                    $notificationService->notification($teacherToken, 'New Comment', $notificationBody);
                }

            } else {
                throw new Exception("Commentable entity not found.");
            }

            DB::commit();
            return $comment->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw new FailedException("Unable to create comment: " . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        try{
            DB::beginTransaction();
            $comment = $this->comment->find($id);

            if (!$comment) {
                throw new NotFoundException();
            }
            $comment = new $this->comment;
            $comment->comment=$data['comment']??$comment->commemt;
            $comment->lesson_id=$data['lesson_id']??$comment->lesson_id;
            $comment->user_id = Auth::id()??$comment->user_id;
            $comment->save();

            DB::commit();

            return $comment->fresh();
        }

        catch(Exception $e){
            DB::rollBack();
            throw new FailedException(("Unable to update comment: "). $e->getMessage());

        }
    }

    public function delete(int $id)
    {
        $comment = $this->comment->find($id);

        if (!$comment) {
            throw new NotFoundException();
        }
        $comment->delete();

        return $comment;
    }

}
