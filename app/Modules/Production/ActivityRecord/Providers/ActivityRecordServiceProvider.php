<?php

namespace App\Modules\Production\ActivityRecord\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Production\ActivityRecord\Repository\ActivityRecordRepository;
use App\Modules\Production\ActivityRecord\Repository\ActivityRecordInterface;

class ActivityRecordServiceProvider extends ServiceProvider
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
        $this->app->bind(ActivityRecordInterface::class, function($app)
        {
            return new ActivityRecordRepository;
        });
    }
}
