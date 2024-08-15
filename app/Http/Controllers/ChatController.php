<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreChatRequest;
use App\Http\Requests\Subcripation\Subcripation\Chat\UpdateChatRequest;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{


    public function __construct(Firestore $firestore)
    {

        $this->middleware(['auth:api'])->only('sendNotification');
    }


    public function store(Request $request)
    {
        try {
            $user1Id = auth()->id();
            $user2Id = $request['user2_id'];
            $maxUserId = max($user1Id, $user2Id);
            $minUserId = min($user1Id, $user2Id);
            $chatRoomName = "ChatRoom{$maxUserId}-{$minUserId}";


            $chatroomDoc = $this->firestore->database()->collection('chatting')->document($chatRoomName);


            $chatRef = $chatroomDoc->collection('chats')->add([
                'message' => $request->message,
                'user1_id' => $user1Id,
                'user2_id' => $user2Id,
                'timestamp' => now()->timestamp,
            ]);

            if ($chatRef) {
                return response()->json(['message' => 'Chat message stored successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to store chat message.'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Firestore store error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function sendNotification(StoreChatRequest $request, NotificationService $notificationService,int $id)
    {
        $user1Id = Auth::id();


        $user2 = User::find($id);

        $userTokens = User::where('id', $id)->pluck('device_token')->toArray();

        $user1 = User::find($user1Id);

            $title = 'New Message';
            $body = $user1->name . ' has sent you a message';
            $additionalData = [
                'type' => 'chat',
                'sender' => $user1,
                'user_id'=>$user1->id,
                'user_name'=>$user1->name,
                'user_phone'=>$user1->phone,
                'user_avatar'=>$user1->avatar,

            ];
            $notificationService->notification($userTokens, $title, $body,$additionalData);


        return [
            'data'=>$additionalData,
            'user2'=>$user2];
    }

}
