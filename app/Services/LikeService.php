<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use App\Models\ReplyOnComment;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnArgument;

class LikeService
{
    use ResponseTrait;

    protected Like $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function like(array $data, NotificationService $notificationService)
    {
        $user = Auth::user();

        if (isset($data['comment_id'])) {
            $likeableType = 'App\Models\Comment';
            $likeableId = $data['comment_id'];
        } elseif (isset($data['reply_on_comment_id'])) {
            $likeableType = 'App\Models\ReplyOnComment';
            $likeableId = $data['reply_on_comment_id'];
        } elseif (isset($data['video_id'])) {
            $likeableType = 'App\Models\Video';
            $likeableId = $data['video_id'];
        }

        $existingLike = Like::where('user_id', $user->id)
            ->where('likeable_type', $likeableType)
            ->where('likeable_id', $likeableId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return $this->successWithData($data, 'dislike', 200);
        } else {
            $like = new Like;
            $like->user_id = $user->id;
            $like->likeable_type = $likeableType;
            $like->likeable_id = $likeableId;
            $like->save();

            return $this->successWithData($data, 'like', 200);
        }
    }
}
