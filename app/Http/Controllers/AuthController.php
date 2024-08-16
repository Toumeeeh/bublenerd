<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\MyMiddlewares\IsAdmin;
use App\Http\Middleware\MyMiddlewares\IsUserVerified;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUSerRequest;
use App\Http\Requests\Money\StoreMoneyRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
use ResponseTrait;
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        $this->middleware(['auth:api'])->only(['logout','update']);
        $this->middleware(IsUserVerified::class)->only('login');
        $this->middleware(['auth:api'])->only(['searchForTeacher','getWallet']);
        $this->middleware(IsAdmin::class)->only('');
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->safe()->all());
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->safe()->all());
    }

    public function loginAsAdmin(LoginRequest $request)
    {
        return $this->authService->loginAsAdmin($request->safe()->all());
    }
    public function logout()
    {
        return $this->authService->logout();
    }

    public function getAllTeacher()
    {
        return $this->authService->getAllTeacher();
    }
    public function getAllUser()
{
    return $this->authService->getAllUser();
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
    public function delete(int $id)
    {
        return $this->authService->delete($id);
    }
    public function getWallet()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Fetch the user along with the wallet
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            throw new NotFoundException("User not found");
        }
        $wallet=$user->wallet;
        // Return the user's wallet
        return $this->successWithData($wallet,  'Operation completed',200);    }
}






