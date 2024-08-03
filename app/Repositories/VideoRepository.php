<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use App\Traits\ResponseTrait;
use App\Traits\StoreVideoTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoRepository implements VideoRepositoryInterface
{
    use ResponseTrait;
    use StoreVideoTrait;
    protected  video $video;

    public function __construct(video $video)
    {
        $this->video = $video;
    }

    public function index()
    {
        return $this->video->get();
    }

    public function getById(int $id)
    {
        $video =  $this->video->where('id', $id)->get();

        if (!$video) {
            throw new NotFoundException();
        }
        return $video;
    }

    public function getByUser(int $userId)
    {

        $user = User::with(['videos' => function ($query) {
            $query->with('userRate');
            $query->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(ratings.rating),0)'));
            }]);
        }])->where('id', $userId)->first();

      if (!$user){

          throw  new NotFoundException('Not found');}

        return $user;

    }

    public function getByUSerAndSubject(int $userId,  int $subjectId)

    {
        $video = Video::with('userRate')
            ->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(ratings.rating),0)'));
            }])->where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->get();


        return $video;

    }
    public function create(array $data)
    {
        try{
            DB::beginTransaction();
            $video = new $this->video;
            $video->name = $data['name'];
            $video->description = $data['description'];
            $video->subject_id=$data['subject_id'];
            $video->user_id=Auth::id();
            if (isset($data['video'])) {
                $video->video = $this->store($data['video'], 'videos');
            }else{
                $video->video =null;
            }
            $video->save();
            preg_match_all('/#(\w+)/', $video->description, $matches);
            $tags = collect($matches[1]);

            $tags->each(function ($tagName) use ($video) {
                $tagModel = Tag::firstOrCreate(['name' => $tagName]);
                $video->tags()->attach($tagModel);
            });
            DB::commit();

            return $video->fresh();

        }catch(Exception $e){
            DB::rollBack();
            throw new FailedException(("Unable to create video: "). $e->getMessage());

        }
    }

    public function update(array $data, int $id)
    {

        try{
            DB::beginTransaction();
            $video = $this->video->find($id);

            if (!$video) {
                throw new NotFoundException();
            }
            $video->name = $data['name']?? $video->name;;
            $video->description = $data['description'] ??$video->description;
            $video->subject_id=$data['subject_id']?? $video->subject_id;
            if (isset($data['video'])) {
                $video->video = $this->store($data['video'], 'video');
            }
            $video->save();

            DB::commit();
            return $video->fresh();
        }catch(Exception $e){
            DB::rollBack();
            throw new UpdateException(("Unable to update video: "). $e->getMessage());

        }
    }

    public function delete(int $id)
    {
        $video = $this->video->find($id);

        if (!$video) {
            throw new NotFoundException();
        }
        $video->delete();

        return $video;
    }

    public function searchForVideo($name)
    {
        $video = Video::with('userRate')
            ->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(ratings.rating),0)'));
                 }])->where('name', 'like', '%' . $name . '%')
                ->get();
        if (!$video) {
            throw new NotFoundException();
        }
        return $video;
    }
}
