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

            Route::get('/getGeneralForm', [
                'as' => 'invoice.getGeneralForm',
                'uses' => 'InvoiceController@getGeneralForm'
            ]);

            Route::get('/getNewInvoiceVersionForm', [
                'as' => 'invoice.getNewInvoiceVersionForm',
                'uses' => 'InvoiceController@getNewInvoiceVersionForm'
            ]);

            Route::post('/save', [
                'as' => 'invoice.save',
                'uses' => 'InvoiceController@save'
            ]);

            Route::post('/delete', [
                'as' => 'invoice.delete',
                'uses' => 'InvoiceController@delete'
            ]);

            Route::get('/getPitsBySearch', [
                'as' => 'invoice.getPitsBySearch',
                'uses' => 'InvoiceController@getPitsBySearch'
            ]);

            Route::get('/getConfigurationInvoiceForm/{idInvoice}', [
                'as' => 'invoice.getConfigurationInvoiceForm',
                'uses' => 'InvoiceController@getConfigurationInvoiceForm'
            ]);

            Route::get('/generatePreview/{idInvoice}', [
                'as' => 'invoice.generatePreview',
                'uses' => 'InvoiceController@generatePreview'
            ]);

        });

    });



