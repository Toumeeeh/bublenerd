<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable=['user_id','likeable_type','likeable_id'];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];
    public function likeable()
    {
        return $this->morphOne(Likeable::class, 'likeable');
    }
public function user(){

}
}
