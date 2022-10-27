<?php
    Route::group(['prefix' => 'production','middleware' => 'auth'], function(){
        $controller = "Admin\Consumable\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'consumable' ], function (){

            Route::post('/getByGroupId', [
                'as' => 'consumables.getByGroupId',
                'uses' => 'ConsumableController@getByGroupId'
            ]);

            Route::post('/searchByString', [
                'as' => 'consumables.searchByString',
                'uses' => 'ConsumableController@searchByString'
            ]);

        });

    });



