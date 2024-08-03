<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Models\Unit;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;


class UnitRepository implements UnitRepositoryInterface
{
    use ResponseTrait;
    protected Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function index()
    {
        return $this->unit->get();
    }

    public function getById(int $id)
    {
        $unit = $this->unit->where('id', $id)->get();

        if (!$unit) {
            throw new NotFoundException();
        }
        return $unit;
    }

    public function create(array $data)
    {
        try {

            $unit = new $this->unit;
            $unit->name = $data['name'];
            $unit->course_id = $data['course_id'];
            $unit->save();
            return $unit->fresh();

        } catch (Exception $e) {
            throw new FailedException(("Unable to create unit ") . $e->getMessage());

        }
    }

    public function update(array $data,int $id)
    {
        try {
            DB::beginTransaction();
            $unit = $this->unit->find($id);

            if (!$unit) {
                throw new NotFoundException();
            }


            $unit->name = $data['name']?? $unit->name;;
            $unit->course_id = $data['course_id'] ?? $unit->course_id;
            $unit->save();
            DB::commit();
            return $unit->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw new FailedException(("Unable to update unite: ") . $e->getMessage());
        }

    }
    public function delete(int $id)
    {
        $unit = $this->unit->find($id);

        if (!$unit) {
            throw new NotFoundException();
        }
        $unit->delete();

        return $unit;
    }
}
