<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;
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
        //
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
    }
}
