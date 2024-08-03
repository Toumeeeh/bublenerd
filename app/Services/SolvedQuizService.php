<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Repositories\SolvedQuizRepository;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class SolvedQuizService
{ use ResponseTrait;
    protected SolvedQuizRepository $solvedQuizRepository;
    public function __construct(SolvedQuizRepository $solvedQuizRepository)
    {
        $this->solvedQuizRepository=$solvedQuizRepository;
    }



        public function create( array $data)
    {
        try {


            $quiz = $this->solvedQuizRepository->create(Arr::only($data,['solve', 'quiz_id','user_id']));

            return $this->successWithData($quiz, 'created successfully',201);
        }catch (FailedException$e) {
            return $this->failed($e->getMessage(), 400);}
    }


}
