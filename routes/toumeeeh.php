<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReplyOnCommentController;
use App\Http\Controllers\SolvedQuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VideoController;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ResetCodePasswordController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\QuizController;



Route::group(['prefix'=>'course'], function () {
    Route::get('/get',   [CourseController::class,'index']);
    Route::get('/getById/{id}',     [CourseController::class,'getById']);
    Route::post('/create',[CourseController::class,'create']);
    Route::post('/update/{id}',[CourseController::class,'update']);
    Route::delete('/delete/{id}',[CourseController::class,'delete']);
    Route::get('/getByUser/{id}',     [CourseController::class,'getByUser']);
    Route::get('/getWithUser/{id}',     [CourseController::class,'getWithUser']);
    Route::get('/getWithLesson/{id}',     [CourseController::class,'getWithLesson']);
    Route::get('/searchForCourse/{name}',     [CourseController::class,'searchForCourse']);
    Route::get('/getByUSerAndSubject/{teacherId}/{subjectId}', [CourseController::class, 'getByUSerAndSubject']);
    Route::post('/approved/{id}',     [CourseController::class,'approved']);
    Route::post('/buyCourse',     [CourseController::class,'buyCourse']);



});

Route::group(['prefix'=>'ResetCodePassword'], function () {
    Route::post('ForgotPassword',  [ResetCodePasswordController::class,'ForgotPassword']);
    Route::post('CodeCheck', [ResetCodePasswordController::class,'CodeCheck']);
    Route::post('ResetPassword', [ResetCodePasswordController::class,'ResetPassword']);
});

Route::group(['prefix'=>'unit'], function () {
    Route::get('/index',   [UnitController::class,'index']);
    Route::get('/getById/{id}',     [UnitController::class,'getById']);
    Route::post('/create',[UnitController::class,'create']);
    Route::post('/update/{id}',[UnitController::class,'update']);
    Route::delete('/delete/{id}',[UnitController::class,'delete']);
});

Route::group(['prefix'=>'lesson'], function () {
    Route::get('/index',   [lessonController::class,'index']);
    Route::get('/getById/{id}',     [lessonController::class,'getById']);
    Route::post('/create',[lessonController::class,'create']);
    Route::post('/update/{id}',[lessonController::class,'update']);
    Route::delete('/delete/{id}',[lessonController::class,'delete']);
    Route::get('/searchForLesson/{name}',     [lessonController::class,'searchForLesson']);

});

Route::group(['prefix'=>'tag'], function () {
    Route::get('/index',   [TagController::class,'index']);
    Route::get('/getById/{id}',     [TagController::class,'getById']);
    Route::delete('/delete/{id}',[TagController::class,'delete']);
    Route::get('/getTagWithCourse/{name}',     [TagController::class,'getTagWithCourse']);
    Route::get('/getTagWithVideo/{name}',     [TagController::class,'getTagWithVideo']);
});

Route::group(['prefix'=>'subject'], function () {
    Route::get('/getBySubject/{id}',     [SubjectController::class,'getBySubject']);
    Route::get('/getByUSer/{id}',     [SubjectController::class,'getByUSer']);
});

Route::group(['prefix'=>'comment'], function () {
    Route::get('/index',   [CommentController::class,'index']);
    Route::get('/getById/{id}',     [CommentController::class,'getById']);
    Route::post('/create',[CommentController::class,'create']);
    Route::post('/update/{id}',[CommentController::class,'update']);
    Route::delete('/delete/{id}',[CommentController::class,'delete']);
    Route::get('/getLessonWithComment/{id}',     [CommentController::class,'getLessonWithComment']);
    Route::get('/getVideoWithComment/{id}',     [CommentController::class,'getVideoWithComment']);
});

Route::group(['prefix'=>'reply'], function () {
    Route::get('/index',   [ReplyOnCommentController::class,'index']);
    Route::get('/getById/{id}',     [ReplyOnCommentController::class,'getById']);
    Route::post('/create',[ReplyOnCommentController::class,'create']);
    Route::delete('/delete/{id}',[ReplyOnCommentController::class,'delete']);
    Route::get('/getReplyOnComment/{id}',     [ReplyOnCommentController::class,'getReplyOnComment']);
});

Route::group(['prefix'=>'rating'], function () {
    Route::get('/index',   [RatingController::class,'index']);
    Route::get('/getById/{id}',     [RatingController::class,'getById']);
    Route::post('/create',[RatingController::class,'create']);
    Route::post('/update/{id}',[RatingController::class,'update']);
    Route::delete('/delete/{id}',[RatingController::class,'delete']);
    Route::get('/sumRatingsForCourse/{id}',     [RatingController::class,'sumRatingsForCourse']);
});

Route::group(['prefix'=>'like'], function () {
    Route::post('/like',   [LikeController::class,'like']);
});

Route::group(['prefix'=>'video'], function () {
    Route::get('/index',   [VideoController::class,'index']);
    Route::get('/getById/{id}',     [VideoController::class,'getById']);
    Route::post('/create',[VideoController::class,'create']);
    Route::post('/update/{id}',[VideoController::class,'update']);
    Route::delete('/delete/{id}',[VideoController::class,'delete']);
    Route::get('/getByUser/{id}',     [VideoController::class,'getByUser']);
    Route::get('/searchForVideo/{name}',     [VideoController::class,'searchForVideo']);
    Route::get('/getByUSerAndSubject/{teacherId}/{subjectId}', [VideoController::class, 'getByUSerAndSubject']);


});

Route::group(['prefix'=>'user'],function(){
    Route::get('getAllTeacher',[AuthController::class,'getAllTeacher']);
    Route::get('getAllUser',[AuthController::class,'getAllUser']);

    Route::get('searchForTeacher/{name}',[AuthController::class,'searchForTeacher']);
    Route::get('/getById/{id}',     [AuthController::class,'getById']);
    Route::post('/update/{id}',[AuthController::class,'update']);
    Route::get('getTeacher/{id}',[AuthController::class,'getTeacher']);
    Route::post('addMoney',[AuthController::class,'addMoney']);
    Route::delete('/delete/{id}',[AuthController::class,'delete']);
    Route::get('getWallet',[AuthController::class,'getWallet']);

});

Route::group(['prefix'=>'quiz'], function () {
    Route::get('/index',   [QuizController::class,'index']);
    Route::get('/getByUer',   [QuizController::class,'getByUser']);
    Route::get('/getById/{id}',   [QuizController::class,'getById']);
    Route::post('/create',[QuizController::class,'create']);
    Route::post('/update/{id}',[QuizController::class,'update']);
    Route::delete('/delete/{id}',[QuizController::class,'delete']);
});

Route::group(['prefix'=>'solve'], function () {
    Route::post('/create',[SolvedQuizController::class,'create']);
});

Route::group(['prefix'=>'chat'], function () {
    Route::post('/store',[ChatController::class,'store']);
    Route::get('/getChatBetweenUsers/{id1}/{id2}',[ChatController::class,'getChatBetweenUsers']);
    Route::get('/sendNotification/{id}',[ChatController::class,'sendNotification']);

});

Route::group(['prefix'=>'Subscription'], function () {
Route::post('/Subscription', [SubscriptionController::class, 'Subscription']);
Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe']);
});

Route::group(['prefix'=>'Book'], function () {
    Route::post('/create',[BookController::class,'create']);
    Route::get('/getById/{id}',   [BookController::class,'getById']);
    Route::get('/index',   [BookController::class,'index']);
});
Route::group(['prefix'=>'notification'], function () {
    Route::get('/index',   [\App\Http\Controllers\NotificationController::class,'index']);
});
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
