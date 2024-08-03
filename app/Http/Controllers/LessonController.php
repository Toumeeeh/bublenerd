<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdmin;
use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Middleware\MyMiddlewares\IsTeacher;
use App\Models\Lesson;
use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Services\LessonService;

class LessonController extends Controller
{

    protected LessonService $lessonService;


    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;

        $this->middleware(['auth:api', IsAdminOrTeacher::class])->only('create','delete','update');
        $this->middleware(['auth:api'])->only('searchForLesson');

    }


    public function index()
    {
        return $this->lessonService->index();
    }


    public function getById(int $id)
    {
        return $this->lessonService->getById($id);
    }


    public function create(StoreLessonRequest $data)
    {
        return $this->lessonService->create($data->safe()->all());
    }


    public function update(UpdateLessonRequest $data, $id)
    {
        return $this->lessonService->update($data->safe()->all(), $id);
    }


    public function delete(int $id)
    {
        return $this->lessonService->delete($id);
    }

    public function searchForLesson($name)
    {
        return $this->lessonService->searchForLesson($name);
    }
}
