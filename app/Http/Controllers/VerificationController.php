<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerification\EmailVerificationRequest;
use App\Http\Requests\EmailVerification\ResendEmailVerificationRequest;
use App\Services\VerificationService;

class VerificationController extends Controller
{
    protected VerificationService $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }


    public function emailVerification(EmailVerificationRequest $request)
    {
        return $this->verificationService->emailVerification($request->safe()->all());
    }

    public function resendEmailVerification(ResendEmailVerificationRequest $request)
    {
        return $this->verificationService->resendEmailVerification($request->safe()['email']);
    }
}
