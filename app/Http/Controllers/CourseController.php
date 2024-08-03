<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Requests\BuyCOurse\BuyRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Services\CourseService;
use App\Services\NotificationService;


class CourseController extends Controller
{
    protected  CourseService $courseService;


    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
        $this->middleware(['auth:api', IsAdminOrTeacher::class])->only('create','delete','update');
        $this->middleware(['auth:api'])->only('getByUser','getWithLesson','searchForCourse','buyCourse');

    }

    public function index()
    {
        return $this->courseService->index();
    }

    public function getById(int $id)
    {
        return $this->courseService->getById($id);
    }

    public function getByUser(int $userId)
    {
        return $this->courseService->getByUser($userId);
    }
    public function getByUSerAndSubject(int $userId,int $teacherId)
    {
        return $this->courseService->getByUSerAndSubject($userId,$teacherId);
    }

    public function getWithUser(int $userId)
    {
        return $this->courseService->getWithUser($userId);
    }

    public function getWithLesson(int $id)
    {
        return $this->courseService->getWithLesson($id);
    }

    public function create(StoreCourseRequest $data,NotificationService $notificationService)
    {
        //dd(env('FIREBASE_CREDENTIALS'));
        return $this->courseService->create($data->safe()->all(),$notificationService);
    }

    public function approved(int $id)
    {
        return $this->courseService->approved($id);
    }
    public function buyCourse(BuyRequest $data)
    {
        return $this->courseService->buyCourse($data->safe()->all());
    }

    public function update(UpdateCourseRequest $data, $id)
    {
        return $this->courseService->update($data->safe()->all(),$id);
    }

    public function delete(int $id)
    {
        return $this->courseService->delete($id);
    }

    public function searchForCourse($name)
    {
        return $this->courseService->searchForCourse($name);
    }

}
