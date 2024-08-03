<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Repositories\lessonRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class LessonService
{
    use ResponseTrait;

    protected lessonRepositoryInterface $lessonRepository;

    public function __construct(lessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }
    public function index(){
        $data = $this->lessonRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }

    public function getById(int $id)
    {
        try {
            $data = $this->lessonRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function create( array $data)
    {
        try {

            $lesson = $this->lessonRepository->create(Arr::only($data,[ 'name', 'video','course_id']));

            return $this->successWithData($lesson, 'created successfully',201);
        }catch (FailedException$e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function update(array $data, int $id)
    {
        try {
            $lesson = $this->lessonRepository->update(Arr::only($data,[ 'name','video','course_id']),$id);

            return $this->successWithData($lesson, 'updated successfully',201);

        }catch (UpdateException $e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function delete(int $id)
    {
        try {
            $this->lessonRepository->delete($id);
            return $this->successWithData('','lesson deleted successfully',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function searchForLesson($name)
    {
        try {
            $data = $this->lessonRepository->searchForLesson($name);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

}
