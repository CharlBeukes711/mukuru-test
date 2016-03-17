<?php

namespace App\Providers;

use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class OrderServiceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('orderService', function($app)
        {
            return new OrderService(
                $app->make('Illuminate\Http\Request'),
                $app->make('App\Models\Repositories\CurrencyRepository'),
                $app->make('App\Models\Repositories\UserRepository')
            );
        });
    }
}
