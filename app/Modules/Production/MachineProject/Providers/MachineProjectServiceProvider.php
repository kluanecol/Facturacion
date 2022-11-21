<?php

namespace App\Modules\Production\MachineProject\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Production\MachineProject\Repository\MachineProjectRepository;
use App\Modules\Production\MachineProject\Repository\MachineProjectInterface;

class MachineProjectServiceProvider extends ServiceProvider
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
        $this->app->bind(MachineProjectInterface::class, function($app)
        {
            return new MachineProjectRepository;
        });
    }
}
