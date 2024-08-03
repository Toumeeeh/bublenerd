<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Models\Course;
use App\Models\Rating;
use App\Models\Ratingable;
use App\Traits\ResponseTrait;
use App\Traits\StorePhotoTrait;
use Exception;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class RatingRepository implements RatingRepositoryInterface
{
    use ResponseTrait;
    use StorePhotoTrait;

    protected Rating $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    public function index()
    {
        return $this->rating->get();
    }

    public function sumRatingsForCourse(int $id)
    {

        $sumOfRatings = Rating::where('course_id', $id)->sum('rating');
        $countOfRatings = Rating::where('course_id', $id)->count();

        if ($countOfRatings > 0) {
            $averageRating = $sumOfRatings / $countOfRatings;
            $scaledRating = round($averageRating , 1);

            return  "$scaledRating/5";
        }
        }

    public function create(array $data)
    {

        if (isset($data['course_id'])) {
            $existingRating = Ratingable::where('ratingable_id', $data['course_id'])
                ->where('ratingable_type', 'App\Models\Course')
                ->first();
            if ($existingRating) {
                throw new FailedException('You already rated this course');
            }
        }


        if (isset($data['video_id'])) {
            $existingRating = Ratingable::where('ratingable_id', $data['video_id'])
                ->where('ratingable_type', 'App\Models\Video')
                ->first();
            if ($existingRating)
                throw new FailedException('You already rated this video');

            }

        try {
            DB::beginTransaction();

            $rating = new $this->rating;
            $rating->rating = $data['rating'];

            $rating->user_id = Auth::id();

            if (isset($data['course_id'])) {
                $ratingabletype = 'App\Models\Course';
                $ratingableId = $data['course_id'];
            }

            if (isset($data['video_id'])){
                $ratingabletype = 'App\Models\Video';
                $ratingableId = $data['video_id'];
            }

            $ratingable = $ratingabletype::find($ratingableId);
            if ($ratingable) {
                $ratingable->ratings()->save($rating, ['user_id' => Auth::id(), 'rating' => $data['rating']]);
            } else {
                throw new Exception("Rateable entity not found.");
            }

            DB::commit();
            return $rating->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw new FailedException("Unable to rate: " . $e->getMessage());
        }
    }



}
