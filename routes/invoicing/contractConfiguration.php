<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth','cors'], function(){
        $controller = "Invoicing\ContractConfiguration\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'contractConfiguration' ], function (){


            Route::post('/save', [
                'as' => 'contractConfiguration.save',
                'uses' => 'ContractConfigurationController@save'
            ]);

            Route::post('/getList', [
                'as' => 'contractConfiguration.getList',
                'uses' => 'ContractConfigurationController@getList'
            ]);

        });

    });



