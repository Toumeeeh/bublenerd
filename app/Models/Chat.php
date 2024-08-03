<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $fillable =['message','user_id1','user_id2','chat_room_id'];

    protected $hidden=['created_at',
        'updated_at'];
    public function chatroom(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }}
