<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth','cors'], function(){
        $controller = "Invoicing\ContractConfiguration\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'contractConfiguration' ], function (){


            Route::post('/save', [
                'as' => 'contractConfigurations.save',
                'uses' => 'ContractConfigurationController@save'
            ]);

        });

    });



