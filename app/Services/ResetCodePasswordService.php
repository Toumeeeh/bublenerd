<?php

namespace App\Services;

use App\Exceptions\FailedException;
use App\Http\Requests\ResetPassword\CheckCodeRequest;
use App\Http\Requests\ResetPassword\ForgotPasswordRequest;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetCodePasswordService
{
    use ResponseTrait;

    public function ForgotPassword(ForgotPasswordRequest $data)
    {
        try {
            // Delete all old codes associated with the user's email
            ResetCodePassword::where('email', $data->email)->delete();

            // Generate random code
            $code = mt_rand(100000, 999999);


            // Create a new code
            $codeData = ResetCodePassword::create([
                'email' => $data->email,
                'code' => $code,
            ]);

            // Send  code to user
            $userName = User::where('email', $data->email)->value('name');
            Mail::to($data->email)->send(new SendCodeResetPassword($code, $userName));

            return $this->successWithMessage('Operation completed', 200);
        } catch (FailedException $e) {
            return $this->failed($e->getMessage(), 400);
        }
    }

    public function CodeCheck(CheckCodeRequest $data)
    {
        // Find the code
        $passwordReset = ResetCodePassword::where('email', $data->email)->first();

        // Check if code has expired (assuming a one-hour expiration)
        if ($passwordReset->created_at->addhour() < now()) {
            $passwordReset->delete();
            return $this->failed('Password code expired', 400);
        }


        return $this->successWithMessage(' code is correct, you can proceed', 200);
    }


    public function ResetPassword (ResetPasswordRequest $data)
    {
        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $data->code);

        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return $this->failed('passwords code expired', 400);
        }

        // find user's email
        $user = User::firstWhere('email', $passwordReset->email);

        // update user password
        $user->update($data->only('password'));

        // delete current code
        $passwordReset->delete();

        $token = auth('api')->login($user);

        $user = $this->userWithToken($user,$token);

        return $this->successWithData($user,'passwords Reset completed');
    }



}
