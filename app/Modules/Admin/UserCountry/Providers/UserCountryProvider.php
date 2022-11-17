<?php

namespace App\Modules\Admin\UserCountry\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\UserCountry\Repository\UserCountryRepository;
use App\Modules\Admin\UserCountry\Repository\UserCountryInterface;

class UserCountryServiceProvider extends ServiceProvider
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
        $this->app->bind(UserCountryInterface::class, function($app)
        {
            return new UserCountryRepository;
        });
    }
}
