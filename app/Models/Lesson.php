<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'video'
];
    protected $hidden =[
        'created_at',
        'updated_at'
    ];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function comments(): morphToMany
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

}
