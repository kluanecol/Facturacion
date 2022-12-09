<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\Parametric\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'parametric' ], function (){

            Route::get('/index', [
                'as' => 'parametric.index',
                'uses' => 'ParametricController@index'
            ]);

            Route::get('/getParametricForm', [
                'as' => 'parametric.getParametricForm',
                'uses' => 'ParametricController@getParametricForm'
            ]);

            Route::get('/getOtherChargeForm', [
                'as' => 'parametric.getOtherChargeForm',
                'uses' => 'ParametricController@getOtherChargeForm'
            ]);

            Route::post('/save', [
                'as' => 'parametric.save',
                'uses' => 'ParametricController@save'
            ]);

            Route::post('/search', [
                'as' => 'parametric.search',
                'uses' => 'ParametricController@search'
            ]);

            Route::post('/changeState', [
                'as' => 'parametric.changeState',
                'uses' => 'ParametricController@changeState'
            ]);
        });

    });


