<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\Invoice\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'invoice' ], function (){

            Route::get('/index/{idContract}', [
                'as' => 'invoice.index',
                'uses' => 'InvoiceController@index'
            ]);

            Route::post('/search', [
                'as' => 'invoice.search',
                'uses' => 'InvoiceController@search'
            ]);

            Route::post('/getGeneralForm', [
                'as' => 'invoice.getGeneralForm',
                'uses' => 'InvoiceController@getGeneralForm'
            ]);

            Route::post('/save', [
                'as' => 'invoice.save',
                'uses' => 'InvoiceController@save'
            ]);

            Route::post('/delete', [
                'as' => 'invoice.delete',
                'uses' => 'InvoiceController@delete'
            ]);

            Route::post('/getPitsBySearch', [
                'as' => 'invoice.getPitsBySearch',
                'uses' => 'InvoiceController@getPitsBySearch'
            ]);

        });

    });



