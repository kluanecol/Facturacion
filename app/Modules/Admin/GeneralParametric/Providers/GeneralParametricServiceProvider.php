<?php

namespace App\Modules\Admin\GeneralParametric\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricRepository;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricInterface;

class GeneralParametricServiceProvider extends ServiceProvider
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
        $this->app->bind(GeneralParametricInterface::class, function($app)
        {
            return new GeneralParametricRepository;
        });
    }
}
