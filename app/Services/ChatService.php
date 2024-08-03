<?php

namespace App\Services;

use App\Events\Chats;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Traits\ResponseTrait;
use  Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging;

class ChatService
{
    use ResponseTrait;

    protected $database;
    protected $messaging;

    public function __construct(Database $database, Messaging $messaging)
    {
        $this->database = $database;
        $this->messaging = $messaging;
    }
    public function index()
    {
        return $this->database->getReference('chats')->getValue();
    }

    public function create(array $data)
    {
        $user1Id = auth()->id();
        $user2Id = $data['user2Id'];
        $maxUserId = max($user1Id, $user2Id);
        $minUserId = min($user1Id, $user2Id);
        $chatRoomName = "ChatRoom{$maxUserId}-{$minUserId}";

        $chatRoomRef = $this->database->getReference('chats/' . $chatRoomName);
        if (!$chatRoomRef->getValue()) {
            $chatRoomRef->set(['name' => $chatRoomName]);
        }

        $chat = [
            'message' => $data['message'],
            'user_id' => $user1Id,
            'timestamp' => now()->timestamp,
        ];

        $chatRoomRef->push($chat);

        $notification = Notification::create('New Message', $data['message']);
        $message = CloudMessage::withTarget('topic', $chatRoomName)->withNotification($notification);
        $this->messaging->send($message);

        return $this->successWithData($chat, 'created successfully', 201);
    }


    public function getChatBetweenUsers(int $id1, int $id2)
    {
        $maxUserId = max($id1, $id2);
        $minUserId = min($id1, $id2);
        $chatRoomName = "ChatRoom{$maxUserId}-{$minUserId}";

        $chats = $this->database->getReference('chats/' . $chatRoomName)->getValue();

        return $chats;
    }
}
