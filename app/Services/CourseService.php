<?php

namespace App\Services;

use App\Exceptions\CourseCreatinoException;
use App\Exceptions\courseNotFoundException;
use App\Exceptions\CourseUpdateException;
use App\Exceptions\FailedException;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Traits\ResponseTrait;
use http\Client\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    use ResponseTrait;

    protected CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function index(){
        $data = $this->courseRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }

    public function getById(int $id)
    {
        try {
            $data = $this->courseRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getByUser(int $userId)
    {
        try {
            $data = $this->courseRepository->getByUser($userId);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getByUSerAndSubject(int $userId, int $teacherId)
    {
        try {
            $data = $this->courseRepository->getByUSerAndSubject($userId,$teacherId);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getWithUser(int $id)
    {
        try {
            $data = $this->courseRepository->getWithUser($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getWithLesson(int $id)
    {
        try {
            $data = $this->courseRepository->getWithLesson($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function create(array $data, NotificationService $notificationService)
    {
        try {
            $course = $this->courseRepository->create($data, $notificationService);
            return $this->successWithData($course, 'created successfully', 201);
        } catch (FailedException $e) {
            return $this->failed($e->getMessage(), 400);
        }
    }
    public function approved(int $id)
    {
        try {
            $data = $this->courseRepository->approved($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function buyCourse(array $data)
    {
        try {
            $data = $this->courseRepository->buyCourse($data);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function update(array $data, int $id)
    {
        try {
            $course = $this->courseRepository->update(Arr::only($data,[ 'name', 'price', 'old_price', 'photo', 'description','user_id','subject_id']),$id);

            return $this->successWithData($course, 'updated successfully',201);

        }catch (CourseUpdateException $e) {
            return $this->failed($e->getMessage(), 422);}
    }

    public function delete(int $id)
    {
        try {
            $this->courseRepository->delete($id);
            return $this->successWithData('','course deleted successfully',200);
        } catch (CourseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
    }
}

    public function searchForCourse($name)
    {
        try {
            $data = $this->courseRepository->searchForCourse($name);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (courseNotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
}
