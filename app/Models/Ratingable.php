<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratingable extends Model
{
    use HasFactory;

    public function ratingable()
    {
        return $this->morphTo();
    }

}
