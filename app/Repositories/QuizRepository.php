<?php

namespace App\Repositories;

use App\Exceptions\courseNotFoundException;
use App\Exceptions\CourseUpdateException;
use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Traits\StorePhotoTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizRepository implements QuizRepositoryInterface
{
    use ResponseTrait;
    use StorePhotoTrait;

    protected Quiz $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function index()
    {
        return $this->quiz->get();
    }

    public function getById(int $courseId)
    {
        $course = Course::with(['quiz' => function ($query) {
            $query->with('userSolveQuiz');
        }])->where('id', $courseId)->first();

        if (!$course) {
            throw new NotFoundException();
        }

        // Transform the response to remove square brackets from user_solve_quiz
        $course->quiz->transform(function ($quiz) {
            $answers = [$quiz->answer1, $quiz->answer2];
            if ($quiz->answer3) {
                $answers[] = $quiz->answer3;
            }
            if ($quiz->answer4) {
                $answers[] = $quiz->answer4;
            }
            $quiz->answers = $answers;
            unset($quiz->answer1, $quiz->answer2, $quiz->answer3, $quiz->answer4);

            return $quiz;
        });

        return $course;
    }



    public function getByUser(int $id)
    {
        $user=User::with('quiz')->where('id',$id)->get();

        if (!$user) {

            throw  new NotFoundException('Not found');
        }

        return $user;
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            // Check if the authenticated user created the course
            $course = Course::where('id', $data['course_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$course) {
                throw new UnauthorizedException("You are not authorized to create a quiz for this course.");
            }

            $quiz = new Quiz;
            $quiz->question = $data['question'];
            $quiz->answer1 = $data['answer1'];
            $quiz->answer2 = $data['answer2'];
            $quiz->correct_answer = $data['correct_answer'];
            $quiz->course_id = $data['course_id'];
            $quiz->user_id = Auth::id();

            // Conditionally set answer3 and answer4 if they are not null
            if (!empty($data['answer3'])) {
                $quiz->answer3 = $data['answer3'];
            }
            if (!empty($data['answer4'])) {
                $quiz->answer4 = $data['answer4'];
            }

            $quiz->save();

            DB::commit();

            // Exclude answer3 and answer4 if they are null from the response
            $response = $quiz->toArray();
            if (empty($response['answer3'])) {
                unset($response['answer3']);
            }
            if (empty($response['answer4'])) {
                unset($response['answer4']);
            }

            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            throw new FailedException("Unable to create quiz: " . $e->getMessage());
        }
    }


    public function update(array $data, int $id)
    {
        try{
            DB::beginTransaction();
            $quiz = $this->quiz->find($id);

            if (!$quiz) {
                throw new courseNotFoundException();
            }

            $quiz = new $this->quiz;
            $quiz->question = $data['question']?? $quiz->question;
            $quiz->answer1 = $data['answer1']?? $quiz->answer1;
            $quiz->answer2= $data['answer2']?? $quiz->answer2;
            $quiz->answer3= $data['answer3']?? $quiz->answer3;
            $quiz->answer4= $data['answer4']?? $quiz->answer4;
            $quiz->correct_answer= $data['correct_answer']?? $quiz->correct_answer;
            $quiz->user_id = Auth::id();
            $quiz->course_id=$data['course_id']??$quiz->course_id;

            $quiz->save();

            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            throw new FailedException(("Unable to update quiz: "). $e->getMessage());

        }
    }

    public function delete(int $id)
    {
        $quiz = $this->quiz->find($id);

        if (!$quiz) {
            throw new NotFoundException();
        }
        $quiz->delete();

        return $quiz;
    }
}

