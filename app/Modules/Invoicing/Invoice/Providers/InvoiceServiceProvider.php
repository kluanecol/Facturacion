<?php

namespace App\Modules\Invoicing\Invoice\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\Invoice\Repository\InvoiceRepository;
use App\Modules\Invoicing\Invoice\Repository\InvoiceInterface;

class InvoiceServiceProvider extends ServiceProvider
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
        $this->app->bind(InvoiceInterface::class, function($app)
        {
            return new InvoiceRepository;
        });
    }
}
