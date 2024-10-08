<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'user/auth'], function (){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/loginAsAdmin', [AuthController::class, 'loginAsAdmin']);


    Route::post('/email-verification', [VerificationController::class, 'emailVerification']);
    Route::post('/resend-email-verification', [VerificationController::class, 'resendEmailVerification']);
//        ->middleware('throttle:resend-email-verification');


});


