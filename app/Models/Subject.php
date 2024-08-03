<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
protected $hidden=[
    'created_at',
    'updated_at'
    ];
    /**
     * RELATIONS
     *
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teachers_has_subjects');
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
