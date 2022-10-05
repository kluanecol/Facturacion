<?php

namespace App\Modules\Admin\Client\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\Client\Repository\ClientRepository;
use App\Modules\Admin\Client\Repository\ClientInterface;

class ClientServiceProvider extends ServiceProvider
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
        $this->app->bind(ClientInterface::class, function($app)
        {
            return new ClientRepository;
        });
    }
}
