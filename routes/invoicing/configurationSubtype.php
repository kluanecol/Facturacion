<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\ConfigurationSubtype\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'configurationSubtype'], function (){


            Route::get('/getForm', [
                'as' => 'configurationSubtype.getForm',
                'uses' => 'ConfigurationSubtypeController@getForm'
            ]);

        });

    });



