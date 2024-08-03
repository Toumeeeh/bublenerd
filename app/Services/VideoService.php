<?php

namespace App\Services;

use App\Exceptions\courseNotFoundException;
use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Repositories\videoRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class VideoService
{
    use ResponseTrait;

    protected videoRepositoryInterface $videoRepository;

    public function __construct(videoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }
    public function index(){
        $data = $this->videoRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }

    public function getById(int $id)
    {
        try {
            $data = $this->videoRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getByUser(int $userId)
    {
        try {
            $data = $this->videoRepository->getByUser($userId);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function getByUSerAndSubject(int $userId, int $teacherId)
    {
        try {
            $data = $this->videoRepository->getByUSerAndSubject($userId,$teacherId);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function create( array $data)
    {
        try {

            $video = $this->videoRepository->create(Arr::only($data,[ 'name', 'description','video','subject_id']));

            return $this->successWithData($video, 'created successfully',201);
        }catch (FailedException$e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function update(array $data, int $id)
    {
        try {
            $video = $this->videoRepository->update(Arr::only($data,[  'name', 'description','video','subject_id']),$id);

            return $this->successWithData($video, 'updated successfully',201);

        }catch (UpdateException $e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function delete(int $id)
    {
        try {
            $this->videoRepository->delete($id);
            return $this->successWithData('','video deleted successfully',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function searchForVideo($name)
    {
        try {
            $data = $this->videoRepository->searchForVideo($name);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
}

