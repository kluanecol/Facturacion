<?php

namespace App\Modules\Invoicing\Parametric\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\Parametric\Repository\ParametricRepository;
use App\Modules\Invoicing\Parametric\Repository\ParametricInterface;

class ParametricServiceProvider extends ServiceProvider
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
        $this->app->bind(ParametricInterface::class, function($app)
        {
            return new ParametricRepository;
        });
    }
}
