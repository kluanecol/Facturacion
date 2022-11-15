<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\Parametric\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'parametric' ], function (){

            Route::post('/getOtherChargeForm', [
                'as' => 'parametric.getOtherChargeForm',
                'uses' => 'ParametricController@getOtherChargeForm'
            ]);

            Route::post('/save', [
                'as' => 'parametric.save',
                'uses' => 'ParametricController@save'
            ]);

        });

    });


