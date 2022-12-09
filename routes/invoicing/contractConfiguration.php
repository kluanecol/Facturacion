<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\ContractConfiguration\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'contractConfiguration' ], function (){


            Route::post('/save', [
                'as' => 'contractConfiguration.save',
                'uses' => 'ContractConfigurationController@save'
            ]);

            Route::get('/getList', [
                'as' => 'contractConfiguration.getList',
                'uses' => 'ContractConfigurationController@getList'
            ]);

            Route::post('/delete', [
                'as' => 'contractConfiguration.delete',
                'uses' => 'ContractConfigurationController@delete'
            ]);

            Route::get('/reloadProgressBar', [
                'as' => 'contractConfiguration.reloadProgressBar',
                'uses' => 'ContractConfigurationController@reloadProgressBar'
            ]);
        });

    });



