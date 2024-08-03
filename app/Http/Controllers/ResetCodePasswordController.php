<?php

namespace App\Http\Controllers;


use App\Http\Requests\ResetPassword\CheckCodeRequest;
use App\Http\Requests\ResetPassword\ForgotPasswordRequest;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Services\ForgetPasswordService;


class ResetCodePasswordController
{

    protected  ForgetPasswordService  $forgetPasswordService;


    public function __construct(ForgetPasswordService $forgetPasswordService, )
    {
        $this->forgetPasswordService = $forgetPasswordService;

    }

    public function ForgotPassword(ForgotPasswordRequest $data){
        return $this->forgetPasswordService->ForgotPassword($data);
    }

    public function CodeCheck(CheckCodeRequest $data){
        return $this->forgetPasswordService->CodeCheck($data);
    }

    public function ResetPassword(ResetPasswordRequest $data){
        return $this->forgetPasswordService->ResetPassword($data);
    }

}
