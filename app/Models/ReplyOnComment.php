<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyOnComment extends Model
{
    use HasFactory;

    protected $fillable=[
        'reply'
    ];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
    public function comment()
    {
      return $this->belongsTo(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
     public function userLike()
    {
        return $this->morphOne(Like::class, 'likeable')
            ->where('user_id', auth()->id());

    }
}
