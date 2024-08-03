<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use App\Services\FirebaseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySubscribedStudents
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function handle(CourseCreated $event)
    {
        $course = $event->course;
        $teacher = $course->teacher;

        // Fetch students who subscribed to this teacher
        $students = $teacher->subscribers;

        foreach ($students as $student) {
            if ($student->device_token) {
                $this->firebaseService->sendNotification(
                    $student->device_token,
                    "New Course Created",
                    "A new course '{$course->title}' has been created by {$teacher->name}."
                );
            }
        }
    }
}
