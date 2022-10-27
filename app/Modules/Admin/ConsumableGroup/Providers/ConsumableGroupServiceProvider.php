<?php

namespace App\Modules\Admin\ConsumableGroup\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\ConsumableGroup\Repository\ConsumableGroupRepository;
use App\Modules\Admin\ConsumableGroup\Repository\ConsumableGroupInterface;

class ConsumableGroupServiceProvider extends ServiceProvider
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
        $this->app->bind(ConsumableGroupInterface::class, function($app)
        {
            return new ConsumableGroupRepository;
        });
    }
}
