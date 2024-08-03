<?php

namespace App\Repositories;

use App\Exceptions\FailedException;
use App\Models\Quiz;
use App\Models\SolvedQuiz;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolvedQuizRepository implements SolvedQuizRepositoryInterface
{
    use ResponseTrait;

    protected SolvedQuiz $solvedQuiz;

    public function __construct(SolvedQuiz $solvedQuiz)
    {
        $this->solvedQuiz = $solvedQuiz;
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            
            $quiz = Quiz::findOrFail($data['quiz_id']);

            $existingSolvedQuiz = SolvedQuiz::where('quiz_id', $data['quiz_id'])
                ->where('user_id', Auth::id())
                ->first();

            if ($existingSolvedQuiz) {
                throw new FailedException('You have already solved this quiz.');
            }


            $solvedQuiz = new SolvedQuiz;
            $solvedQuiz->solve = $data['solve'];
            $solvedQuiz->quiz_id = $data['quiz_id'];
            $solvedQuiz->user_id = Auth::id();
            $solvedQuiz->save();


            if ($quiz->Correct_answer === $data['solve']) {
                DB::commit();
                return $solvedQuiz->fresh();

            }
            else {
                DB::commit();
                throw new FailedException('Incorrect answer. Your answer has been saved, but it is wrong.');
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new FailedException("Unable to solve this quiz: " . $e->getMessage());
        }
    }

}






