<?php

namespace App\Modules\Admin\Consumable\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\Consumable\Repository\ConsumableRepository;
use App\Modules\Admin\Consumable\Repository\ConsumableInterface;

class ConsumableServiceProvider extends ServiceProvider
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
        $this->app->bind(ConsumableInterface::class, function($app)
        {
            return new ConsumableRepository;
        });
    }
}
