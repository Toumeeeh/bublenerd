<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'old_price',
        'photo',
        'description',
        'user_id',
        'subject_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::Class);
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    public function ratings()
    {
        return $this->morphToMany(Rating::class, 'ratingable');
    }
    public function userRate()
    {
        return $this->morphOne(Ratingable::class, 'ratingable')
            ->where('user_id', auth()->id())
            ->select(['id',  'rating','rating_id', 'user_id', 'ratingable_id', 'ratingable_type']);
    }

    public function quiz()
    {
    return $this->Hasmany(Quiz::class);
    }
}
