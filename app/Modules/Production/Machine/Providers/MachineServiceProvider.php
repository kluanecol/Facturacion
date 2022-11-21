<?php

namespace App\Modules\Production\Machine\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Production\Machine\Repository\MachineRepository;
use App\Modules\Production\Machine\Repository\MachineInterface;

class MachineServiceProvider extends ServiceProvider
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
        $this->app->bind(MachineInterface::class, function($app)
        {
            return new MachineRepository;
        });
    }
}
