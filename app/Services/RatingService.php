<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Repositories\RatingRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class RatingService
{
    use ResponseTrait;

    protected RatingRepositoryInterface $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }
    public function index(){
        $data = $this->ratingRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }
    public function create( array $data)
    {
        try {

            $Rating = $this->ratingRepository->create(Arr::only($data,[ 'rating', 'course_id','video_id','user_id']));

            return $this->successWithData($Rating, 'created successfully',201);

        }catch (FailedException $e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function sumRatingsForCourse(int $id)
    {
        try {
            $data = $this->ratingRepository->sumRatingsForCourse($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

}
