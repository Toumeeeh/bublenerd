<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'course_id',
    ];
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
    public function lessons():HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
