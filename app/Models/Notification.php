<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'course_id'];
    protected $hidden=['created_at',
        'updated_at'];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
