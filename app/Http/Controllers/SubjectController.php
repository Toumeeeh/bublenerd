<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdminOrTeacher;
use App\Http\Requests\subject\StoreSubjectRequest;
use App\Http\Requests\subject\UpdateSubjectRequest;
use App\Models\Subject;
use App\Services\SubjectService;

class SubjectController extends Controller
{
    protected subjectService $subjectService;


    public function __construct(subjectService $subjectService)
    {
        $this->subjectService = $subjectService;
        $this->middleware(['auth:api', IsAdminOrTeacher::class])->only('create');
    }
    public function index()
    {

    }

    public function getBySubject(int $subjectId)
    {
        return $this->subjectService->getBySubject($subjectId);
    }

    public function getByUSer(int $subjectId)
    {
        return $this->subjectService->getByUSer($subjectId);
    }
    public function create()
    {
        //
    }


    public function store(StoreSubjectRequest $request)
    {
        //
    }





    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        //
    }

    public function destroy(Subject $subject)
    {
        //
    }
}
