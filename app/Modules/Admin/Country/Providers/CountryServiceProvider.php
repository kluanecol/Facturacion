<?php

namespace App\Modules\Admin\Country\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\Country\Repository\CountryRepository;
use App\Modules\Admin\Country\Repository\CountryInterface;

class CountryServiceProvider extends ServiceProvider
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
        $this->app->bind(CountryInterface::class, function($app)
        {
            return new CountryRepository;
        });
    }
}
