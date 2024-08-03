<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;
    protected $fillable=[
    'name'
];
    protected $hidden =[
        'created_at',
        'updated_at'

    ];

    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    public function taggables()
    {
        return $this->morphMany(Taggable::class, 'tag');
    }
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}
