<?php

namespace App\Modules\Invoicing\Contract\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Invoicing\Contract\Repository\ContractRepository;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;

class ContractServiceProvider extends ServiceProvider
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
        $this->app->bind(ContractInterface::class, function($app)
        {
            return new ContractRepository;
        });
    }
}
