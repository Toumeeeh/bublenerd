<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepository;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\RatingRepository;
use App\Repositories\RatingRepositoryInterface;
use App\Repositories\ReplyOnCommentRepository;
use App\Repositories\ReplyOnCommentRepositoryInterface;
use App\Repositories\UnitRepository;
use App\Repositories\UnitRepositoryInterface;
use App\Repositories\VideoRepository;
use App\Repositories\VideoRepositoryInterface;
use App\Services\AuthService;
use App\Services\CommentService;
use App\Services\CourseService;
use App\Services\LessonService;
use App\Services\RatingService;
use App\Services\ReplyOnCommentService;
use App\Services\UnitService;
use App\Services\VideoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthService::class, function ($app) {
            return new  AuthService($app->make(AuthRepositoryInterface::class));
        });

        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(CourseService::class, function ($app) {
            return new CourseService($app->make(CourseRepositoryInterface::class));
        });
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(unitService::class, function ($app) {
            return new UnitService($app->make(UnitRepositoryInterface::class));
        });
        $this->app->bind(lessonRepositoryInterface::class, lessonRepository::class);
        $this->app->bind(lessonService::class, function ($app) {
            return new lessonService($app->make(lessonRepositoryInterface::class));
        });
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CommentService::class, function ($app) {
            return new CommentService($app->make(CommentRepositoryInterface::class));
        });
        $this->app->bind(ReplyOnCommentRepositoryInterface::class, ReplyOnCommentRepository::class);
        $this->app->bind(ReplyOnCommentService::class, function ($app) {
            return   new ReplyOnCommentService($app->make(ReplyOnCommentRepositoryInterface::class));
        });
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
        $this->app->bind(RatingService::class, function ($app) {
            return   new RatingService($app->make(RatingRepositoryInterface::class));
        });
        $this->app->bind( VideoRepositoryInterface::class,  VideoRepository::class);
        $this->app->bind( VideoService::class, function ($app) {
            return   new VideoService($app->make( VideoRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
