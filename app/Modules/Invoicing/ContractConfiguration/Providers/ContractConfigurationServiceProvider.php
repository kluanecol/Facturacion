<?php

namespace App\Modules\Invoicing\ContractConfiguration\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationInterface;

class ContractConfigurationServiceProvider extends ServiceProvider
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
        $this->app->bind(ContractConfigurationInterface::class, function($app)
        {
            return new ContractConfigurationRepository;
        });
    }
}
