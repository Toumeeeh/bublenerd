<?php

namespace App\Events;

use App\Models\Course;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCreated
{
    use Dispatchable, SerializesModels;

    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }
}
