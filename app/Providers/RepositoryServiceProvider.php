<?php

namespace App\Providers;

use App\Models\Entities\Currency;
use App\Models\Repositories\CurrencyRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
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
        $this->app->bind('Repositories\Interfaces\CurrencyInterface', function()
        {
            return new CurrencyRepository();
        });
    }
}
