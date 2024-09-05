<?php

namespace App\Providers;

use App\Services\CommentService;
use App\Services\FileService;
use App\Services\RecipeService;
use App\Services\Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Service::class, RecipeService::class);
        $this->app->bind(Service::class, FileService::class);
        $this->app->bind(Service::class, CommentService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
