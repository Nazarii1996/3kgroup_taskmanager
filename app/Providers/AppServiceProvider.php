<?php

namespace App\Providers;

use App\Models\Tasks;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view)
        {
            $statuses=Tasks::$statuses;
            $view->with('statuses', $statuses);
        });
    }
}
