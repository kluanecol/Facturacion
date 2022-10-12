<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;

class ConfigurationSubtypeServiceProvider extends ServiceProvider
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
        $this->app->bind(ConfigurationSubtypeInterface::class, function($app)
        {
            return new ConfigurationSubtypeRepository;
        });
    }
}
