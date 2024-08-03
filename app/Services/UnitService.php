<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Repositories\UnitRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class UnitService
{
    use ResponseTrait;

    protected UnitRepositoryInterface $unitRepository;

    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }
    public function index()
    {
        $data = $this->unitRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }
    public function getById(int $id)
    {
        try {
            $data = $this->unitRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function create( array $data)
    {
        try {

            $unit = $this->unitRepository->create(Arr::only($data,[ 'name', 'course_id']));
            return $this->successWithData($unit, 'created successfully',201);
        }catch (FailedException $e) {
            return $this->failed($e->getMessage(), 400);}
    }



    public function update(array $data, int $id)
    {
        try {
            $unit = $this->unitRepository->update(Arr::only($data,[ 'name','course_id']),$id);

            return $this->successWithData($unit, 'updated successfully',201);

        }catch (UpdateException $e) {
            return $this->failed($e->getMessage(), 422);}
    }

    public function delete(int $id)
    {
        try {
            $this->unitRepository->delete($id);
            return $this->successWithData('','unit deleted successfully',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }


}
