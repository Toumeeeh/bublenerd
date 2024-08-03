<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
use ResponseTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type',
        'name',
        'email',
        'phone',
        'school',
        'bio',
        'password',
        'photo',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', //todo: where should i hash the password?
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user_type' => $this->user_type
        ];
    }

    /**
     * RELATIONS
     *
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teachers_has_subjects');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable');
    }

    public function replys()
    {
        return $this->hasMany(Comment::class, 'commentable');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    public function userSubscribe()
    {
         return $this->hasMany(Subscription::class, 'teacher_id')
            ->where('user_id', auth()->id());
    }


}
