<?php

namespace App\Modules\Production\OperationRecord\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Production\OperationRecord\Repository\OperationRecordRepository;
use App\Modules\Production\OperationRecord\Repository\OperationRecordInterface;

class OperationRecordServiceProvider extends ServiceProvider
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
        $this->app->bind(OperationRecordInterface::class, function($app)
        {
            return new OperationRecordRepository;
        });
    }
}
