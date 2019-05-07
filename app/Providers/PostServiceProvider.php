<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\TagRepositoryInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;
use App\Services\TagService;
use App\Services\TagServiceInterface;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            PostServiceInterface::class,
            PostService::class
        );

        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );

        $this->app->bind(
            TagServiceInterface::class,
            TagService::class
        );

        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
    }
}
