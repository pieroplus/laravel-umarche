<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\http\ServiceTest\Sample;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind('sample', Sample::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
