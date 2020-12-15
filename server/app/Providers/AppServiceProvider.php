<?php

namespace GetTheTrophy\Providers;

use Illuminate\Support\Facades\Schema;
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
        //register botman - workaround for https://github.com/botman/botman/issues/1223
        $this->app->singleton(\BotMan\BotMan\BotMan::class, function ($app) {
            return $app->make('botman');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Set default String Length for Database
        Schema::defaultStringLength(191);
    }
}
