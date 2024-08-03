<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsStudent;
use App\Http\Requests\Rating\StoreRatingRequest;
use Illuminate\Http\Request;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected  RatingService $RatingService;


    public function __construct(RatingService $RatingService)
    {
        $this->RatingService = $RatingService;
        $this->middleware(['auth:api',IsStudent::class])->only('create');
        $this->middleware(['auth:api'])->only('sumRatingsForCourse');

    }

    public function index()
    {
        return $this->RatingService->index();
    }
    public function create(StoreRatingRequest $data)
    {
        return $this->RatingService->create(($data->safe()->all()));
    }
    public function sumRatingsForCourse(int $id)
    {
        return $this->RatingService->sumRatingsForCourse($id);
    }
}
