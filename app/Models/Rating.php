<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable=[
        'rating',
        'ratingable_type',
        'ratingable_id',
    ];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'ratingable');
    }

    public function ratingables()
    {
        return $this->morphMany(Ratingable::class, 'rating');
    }
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'ratingable');
    }

}
