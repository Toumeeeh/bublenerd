<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    use ResponseTrait;
    public function Subscription(array $data)
    {
        $teacherId=$data['teacher_id'];

        if ($teacherId == Auth::id()) {
            return $this->failed('You cannot subscribe to yourself.', 400);
        }


        if (!User::where('id', $teacherId)->where('user_type', 'teacher')->exists()) {
            return $this->failed('Invalid teacher ID or the user is not a teacher.', 400);
        }
        $subscription=Subscription::where('user_id', Auth::id())
            ->where('teacher_id', $teacherId)
            ->first();

        if($subscription) {
            $subscription->delete();

            return $this->successWithMessage( 'Unsubscribed', 200);
        }
    else {
            Subscription::create([
                'user_id' => Auth::id(),
                'teacher_id' => $data['teacher_id'],
            ]);

        return $this->successWithMessage( 'subscribed', 200);
        }
    }
}
