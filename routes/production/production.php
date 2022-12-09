<?php
    Route::group(['prefix' => 'production','middleware' => 'auth'], function(){
        $controller = "Admin\Consumable\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'consumable' ], function (){

            Route::get('/getByGroupId', [
                'as' => 'consumables.getByGroupId',
                'uses' => 'ConsumableController@getByGroupId'
            ]);

            Route::get('/searchByString', [
                'as' => 'consumables.searchByString',
                'uses' => 'ConsumableController@searchByString'
            ]);

        });

    });



