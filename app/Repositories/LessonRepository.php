<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Models\lesson;
use App\Traits\ResponseTrait;
use App\Traits\StoreVideoTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonRepository implements LessonRepositoryInterface
{
    use ResponseTrait;
    use StoreVideoTrait;
    protected  lesson $lesson;

    public function __construct(lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function index()
    {
        return $this->lesson->get();
    }

    public function getById(int $id)
    {
        $lesson =  $this->lesson->where('id', $id)->get();

        if (!$lesson) {
            throw new NotFoundException();
        }
        return $lesson;
    }

    public function create(array $data)
    {
        try{
            DB::beginTransaction();
            $lesson = new $this->lesson;
            $lesson->name = $data['name'];
            $lesson->course_id =$data['course_id'];
            if (isset($data['video'])) {
                $lesson->video = $this->store($data['video'], 'lesson_videos');
            }else{
                $lesson->video =null;
            }
            $lesson->save();
            DB::commit();
            return $lesson->fresh();

        }catch(Exception $e){
            DB::rollBack();
            throw new FailedException(("Unable to create lesson: "). $e->getMessage());

        }
    }

    public function update(array $data, int $id)
    {

        try{
            DB::beginTransaction();
            $lesson = $this->lesson->find($id);

            if (!$lesson) {
                throw new NotFoundException();
            }
            $lesson->name = $data['name']?? $lesson->name;;
            $lesson->course_id =$data['course_id']??$lesson->unit_id;
            if (isset($data['video'])) {
                $lesson->video = $this->store($data['video'], 'lesson_videos');
            }
            $lesson->save();

            DB::commit();
            return $lesson->fresh();
        }catch(Exception $e){
            DB::rollBack();
            throw new UpdateException(("Unable to update lesson: "). $e->getMessage());

        }
    }

    public function delete(int $id)
    {
        $lesson = $this->lesson->find($id);

        if (!$lesson) {
            throw new NotFoundException();
        }
        $lesson->delete();

        return $lesson;
    }
    public function searchForLesson($name)
    {
        $lesson= Lesson::where('name', 'like', '%' . $name . '%')
            ->get();
        if (!$lesson) {
            throw new NotFoundException();
        }
        return $lesson;
    }
}
