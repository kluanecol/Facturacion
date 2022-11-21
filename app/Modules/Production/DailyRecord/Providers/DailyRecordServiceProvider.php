<?php

namespace App\Modules\Production\DailyRecord\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Production\DailyRecord\Repository\DailyRecordRepository;
use App\Modules\Production\DailyRecord\Repository\DailyRecordInterface;

class DailyRecordServiceProvider extends ServiceProvider
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
        $this->app->bind(DailyRecordInterface::class, function($app)
        {
            return new DailyRecordRepository;
        });
    }
}
