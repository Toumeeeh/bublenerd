<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chats implements  ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $chatRoomName;

    public function __construct(Chat $chat, $chatRoomName)
    {
        $this->chat = $chat;
        $this->chatRoomName = $chatRoomName;
    }
    public function broadcastOn()
    {
        return new PrivateChannel( $this->chatRoomName);
    }
    public function broadcastAs()
    {
        return 'new-chat-message';
    }
        public function broadcastWith()
    {
        return [
            'message' => $this->chat->message,
            'user' => $this->chat->user1Id,
            'user2' => $this->chat->user2Id,

            'created_at' => $this->chat->created_at->toDateTimeString(),
        ];
    }
}
