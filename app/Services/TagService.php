<?php

namespace App\Services;
use App\Exceptions\NotFoundException;
use App\Models\Course;
use App\Models\Rating;
use App\Models\Tag;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;


class TagService
{
    use ResponseTrait;
    protected  tag $tag;

    public function __construct(tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        return $this->tag->get();
    }

    public function getById(int $id)
    {
        $tag = $this->tag->with('courses')->where('id', $id)->first();

        if (!$tag) {
            throw new NotFoundException();
        }
        return $this->successWithData($tag,'Operation completed',200);
    }

    public function getTagWithCourse(String $name)
    {
        $tag = $this->tag->with(['courses' => function ($query) {
            $query->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(ratings.rating),0)'));
            }]);
        }])->where('name', $name)->first();

        if (!$tag) {
            throw new NotFoundException();
        }

        return $this->successWithData($tag, 'Operation completed', 200);
    }

    public function getTagWithVideo(String $name)
    {

        $tag = $this->tag->with(['videos' => function ($query) {
            $query->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(ratings.rating),0)'));
            }]);
        }])->where('name', $name)->first();
        if (!$tag) {
            throw new NotFoundException();
        }
        return $this->successWithData($tag,'Operation completed',200);
    }

    public function delete(int $id)
    {
        $tag = $this->tag->find($id);

        if (!$tag) {
            throw new NotFoundException();
        }
        $tag->delete();
        return $this->successWithMessage('tag deleted successfully',200);    }
}
