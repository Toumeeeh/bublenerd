<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdmin;
use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Middleware\MyMiddlewares\IsTeacher;
use App\Http\Requests\video\StoreVideoRequest;
use App\Http\Requests\video\UpdateVideoRequest;
use App\Services\VideoService;

class VideoController extends Controller
{
    protected videoService $videoService;


    public function __construct(videoService $videoService)
    {
        $this->videoService = $videoService;
        $this->middleware(['auth:api', IsAdminOrTeacher::class])->only('create','delete','update');
        $this->middleware(['auth:api'])->only('getByUser','searchForVideo');
    }

    public function index()
    {
        return $this->videoService->index();
    }

    public function getById(int $id)
    {
        return $this->videoService->getById($id);
    }

    public function getByUser(int $userId)
    {
        return $this->videoService->getByUser($userId);
    }
    public function getByUSerAndSubject(int $userId,int $teacherId)
    {
        return $this->videoService->getByUSerAndSubject($userId,$teacherId);
    }

    public function create(StorevideoRequest $data)
    {
        return $this->videoService->create($data->safe()->all());
    }

    public function update(UpdatevideoRequest $data, $id)
    {
        return $this->videoService->update($data->safe()->all(), $id);
    }

    public function delete(int $id)
    {
        return $this->videoService->delete($id);
    }

    public function searchForVideo($name)
    {
        return $this->videoService->searchForVideo($name);
    }

}
