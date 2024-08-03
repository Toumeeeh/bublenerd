<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'comment',
        ''
    ];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
    public function lessons(): MorphToMany
    {
    return $this->morphedByMany(Lesson::class, 'commentable');
    }
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reply()
    {
        return $this->hasMany(ReplyOnComment::class);
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
    public function videos(): MorphToMany
    {
        return $this->morphedByMany(video::class, 'commentable');
    }



}
