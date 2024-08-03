<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddlewares\IsAdmin;
use App\Http\Middleware\MyMiddlewares\IsUserVerified;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUSerRequest;
use App\Http\Requests\Money\StoreMoneyRequest;
use App\Http\Requests\Money\StoreMonyRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        $this->middleware(['auth:api'])->only(['logout','update']);
        $this->middleware(IsUserVerified::class)->only('login');
        $this->middleware(['auth:api'])->only(['getAllTeacher','searchForTeacher','getTeacher']);
        $this->middleware(IsAdmin::class)->only('addMoney');
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->safe()->all());
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->safe()->all());
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function getAllTeacher()
    {
        return $this->authService->getAllTeacher();
    }
    public function getTeacher(int $id)
    {
        return $this->authService->getTeacher($id);
    }
    public function searchForTeacher($name)
    {
        return $this->authService->searchForTeacher($name);
    }

    public function getById(int $id)
    {
        return $this->authService->getById($id);
    }
    public function update(UpdateUSerRequest $data,int $id)
    {
        return $this->authService->update($data->safe()->all(),$id);

    }
    public function addMoney(StoreMoneyRequest $data)
    {
        return $this->authService->addMoney($data->safe()->all());




    }
}






