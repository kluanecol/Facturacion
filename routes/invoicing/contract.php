<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\Contract\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'contracts' ], function (){

            Route::get('/index', [
                'as' => 'contracts.index',
                'uses' => 'ContractController@index'
            ]);


        });

    });


