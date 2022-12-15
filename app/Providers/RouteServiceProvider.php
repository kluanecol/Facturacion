<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $namespaceModules = 'App\Modules';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapWebContractRoutes();

        $this->mapWebInvoiceRoutes();

        $this->mapWebConfigurationSubtypeRoutes();

        $this->mapWebContractConfigurationRoutes();

        $this->mapWebParametricRoutes();

        $this->mapWebConsumableRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapWebContractRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/invoicing/contract.php'));
    }

    protected function mapWebInvoiceRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/invoicing/invoice.php'));
    }

    protected function mapWebConfigurationSubtypeRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/invoicing/configurationSubtype.php'));
    }

    protected function mapWebContractConfigurationRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/invoicing/contractConfiguration.php'));
    }

    protected function mapWebConsumableRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/production/production.php'));
    }

    protected function mapWebParametricRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/invoicing/parametric.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespaceModules)
             ->group(base_path('routes/api.php'));
    }
}
