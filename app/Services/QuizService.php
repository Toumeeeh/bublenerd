<?php

namespace App\Services;

use App\Exceptions\courseNotFoundException;
use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UpdateException;
use App\Repositories\QuizRepository;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class QuizService
{
    use ResponseTrait;
    protected QuizRepository $quizRepository;
    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository=$quizRepository;
    }

    public function index(){
        $data = $this->quiezRepository->index();

        return $this->successWithData($data, 'operation completed', 200);
    }

    public function getById(int $courseId)

    {
        try {
            $data = $this->quizRepository->getById($courseId);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getByUser(int $id)

    {
        try {
            $data = $this->quizRepository->getByUser($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function create( array $data)
    {
        try {


            $quiz = $this->quizRepository->create(Arr::only($data,[ 'question','answer1','answer2','answer3','answer4','correct_answer','user_id','course_id']));

            return $this->successWithData($quiz, 'created successfully',201);
        }catch (FailedException$e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function update(array $data, int $id)
    {
        try {
            $quiz = $this->quizRepository->update(Arr::only($data,[ 'question','answer1','answer2','answer3','answer4','correct_answer','user_id','course_id']),$id);

            return $this->successWithData($quiz, 'updated successfully',201);

        }catch (UpdateException $e) {
            return $this->failed($e->getMessage(), 400);}
    }

    public function delete(int $id)
    {
        try {
            $this->quizRepository->delete($id);
            return $this->successWithData('','quiz deleted successfully',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
}
