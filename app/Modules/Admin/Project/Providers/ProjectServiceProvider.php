<?php

namespace App\Modules\Admin\Project\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\Project\Repository\ProjectRepository;
use App\Modules\Admin\Project\Repository\ProjectInterface;

class ProjectServiceProvider extends ServiceProvider
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
        $this->app->bind(ProjectInterface::class, function($app)
        {
            return new ProjectRepository;
        });
    }
}
