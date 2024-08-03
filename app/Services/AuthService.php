<?php

namespace App\Services;

use App\Exceptions\courseNotFoundException;
use App\Exceptions\CourseUpdateException;
use App\Exceptions\FailedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UserException;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

class AuthService
{
    use ResponseTrait;

    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        try {

            $this->authRepository->register($data);

            return $this->successWithMessage('Register complete and need verification', 201);
        }catch (\Exception $e) {
            return $this->failed($e->getMessage(), 422);
        }
    }

    public function login(array $credentials)
    {
        try {
            $userWithToken = $this->authRepository->login($credentials);

            return $this->successWithData($userWithToken, 'logged in successfully');
        }catch (\Exception $e){
            return $this->failed($e->getMessage(), 401);
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();

            return $this->successWithMessage('logged out successfully');
        }catch (\Exception $e){
            return $this->failed($e->getMessage(), 422);
        }
    }

    public function getAllTeacher(){

      $data=$this->authRepository->getAllTeacher();

      return $this->successWithData($data,'operation completed');
    }
    public function getTeacher(int $id){

        $data=$this->authRepository->getTeacher($id);

        return $this->successWithData($data,'operation completed');
    }
    public function searchForTeacher($name)
    {
        try {
            $data = $this->authRepository->searchForTeacher($name);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->authRepository->getById($id);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
    public function update(array $data, int $id)
    {
        try {
            $user = $this->authRepository->update(Arr::only($data,[ 'name', 'user_type','email','phone','school','bio', 'avatar',]),$id);

            return $this->successWithData($user, 'updated successfully',201);

        }catch (FailedException $e) {
            return $this->failed($e->getMessage(), 422);}
    }
    public function addMoney(array $data)
    {
        try {
            $data = $this->authRepository->addMoney($data);
            return $this->successWithData($data,  'Operation completed',200);
        } catch (NotFoundException $e) {
            return $this->failed($e->getMessage(), 404);
        }
    }
}
