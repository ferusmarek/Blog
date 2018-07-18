<?php

namespace App\Providers;
use App\Post;
use Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::saved(function($post){
            Cache::forget('all-posts');
        });
        Post::deleted(function($post){
            Cache::forget('all-posts');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
       $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
   }
    }
}
