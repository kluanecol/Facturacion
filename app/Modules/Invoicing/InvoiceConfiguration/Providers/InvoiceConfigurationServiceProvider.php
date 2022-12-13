<?php

namespace App\Modules\Invoicing\InvoiceConfiguration\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\InvoiceConfiguration\Repository\InvoiceConfigurationRepository;
use App\Modules\Invoicing\InvoiceConfiguration\Repository\InvoiceConfigurationInterface;

class InvoiceConfigurationServiceProvider extends ServiceProvider
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
        $this->app->bind(InvoiceConfigurationInterface::class, function($app)
        {
            return new InvoiceConfigurationRepository;
        });
    }
}
