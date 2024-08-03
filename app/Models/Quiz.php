<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function UserSolveQuiz()
    {
        return $this->hasMany(SolvedQuiz::class)
            ->where('user_id', auth()->id());
         //  ->select(['id','solve','quiz_id','user_id']);

    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}
