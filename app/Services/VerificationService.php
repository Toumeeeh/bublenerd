<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\User;
use App\Traits\ResponseTrait;
use NextApps\VerificationCode\VerificationCode;

class VerificationService
{

    use ResponseTrait;

    public function emailVerification(array $data)
    {
        try {
            if(VerificationCode::verify($data['code'], $data['email']))
            {
                $user = User::where('email', $data['email'])->first();

                $user->markEmailAsVerified();

//                $token = JWTAuth::fromUser($user); todo: the different?
                $token = auth('api')->login($user);

                $user = $this->userWithToken($user, $token);
                return $this->successWithData($user, 'register complete successfully');
            }
            else
                throw new UserException('wrong code');


        }catch (\Exception $e){
            return $this->failed($e->getMessage(), 422);
        }
    }

    public function resendEmailVerification(string $email)
    {
        try {
            VerificationCode::send($email);
            return $this->successWithMessage('new email has been send');
        }catch (\Exception $e){
            return $this->failed($e->getMessage());
        }
    }











}
