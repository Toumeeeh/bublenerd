<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Services\UnitService;

class UnitController extends Controller
{
protected UnitService $unitService;

public function __construct(UnitService $unitService){

    $this->unitService=$unitService;
    $this->middleware(['auth:api'])->only('create');
}
    public function index()
    {
      return $this->unitService->index();
    }

    public function getById(int $id)
    {
      return  $this->unitService->getById( $id);
    }

    public function create(StoreUnitRequest $data)
    {
       return $this->unitService->create($data->safe()->all());
    }


    public function update(UpdateUnitRequest $data,  $id)
    {
         return $this->unitService->update($data->safe()->all(),$id);
    }


    public function delete(int $id)
    {
      return $this->unitService->delete($id);
    }
}
