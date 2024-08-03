<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\UpdateChatRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;

class ChatController extends Controller
{
    protected $firestore;

    public function __construct(Firestore $firestore)
    {
        $this->firestore = $firestore;
        $this->middleware(['auth:api']);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user1Id = auth()->id();
            $user2Id = $request['user2_id'];
            $maxUserId = max($user1Id, $user2Id);
            $minUserId = min($user1Id, $user2Id);
            $chatRoomName = "ChatRoom{$maxUserId}-{$minUserId}";

            // Create or access the 'chatrooms' collection

            $chatroomDoc = $this->firestore->database()->collection('chatting')->document($chatRoomName);

            // Create or access the 'chats' subcollection
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
