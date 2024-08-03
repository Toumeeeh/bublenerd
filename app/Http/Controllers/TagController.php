<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdmin;
use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Middleware\MyMiddlewares\IsTeacher;
use App\Models\Tag;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Services\TagService;

class TagController extends Controller
{

    protected TagService $TagService;


    public function __construct(TagService $TagService)
    {
        $this->TagService = $TagService;
        $this->middleware(['auth:api', IsAdminOrTeacher::class])->only('create','delete','update');
        $this->middleware(['auth:api'])->only('getTagWithCourse','getTagWithVideo');
    }


    public function index()
    {
        return $this->TagService->index();
    }


    public function getById(int $id)
    {
        return $this->TagService->getById($id);
    }

    public function getTagWithCourse(String $name)
    {
        return $this->TagService->getTagWithCourse($name);
    }

    public function getTagWithVideo(String $name)
    {
        return $this->TagService->getTagWithVideo($name);
    }

    public function delete(int $id)
    {
        return $this->TagService->delete($id);
    }
}
