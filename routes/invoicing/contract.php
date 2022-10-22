<?php
    Route::group(['prefix' => 'invoicing','middleware' => 'auth'], function(){
        $controller = "Invoicing\Contract\Controllers";

        Route::group(['namespace' => $controller, 'prefix' => 'contract' ], function (){

            Route::get('/index', [
                'as' => 'contracts.index',
                'uses' => 'ContractController@index'
            ]);

            Route::post('/search', [
                'as' => 'contracts.search',
                'uses' => 'ContractController@search'
            ]);

            Route::post('/getContractForm', [
                'as' => 'contracts.getContractForm',
                'uses' => 'ContractController@getContractForm'
            ]);

            Route::post('/save', [
                'as' => 'contracts.save',
                'uses' => 'ContractController@save'
            ]);

            Route::post('/delete', [
                'as' => 'contracts.delete',
                'uses' => 'ContractController@delete'
            ]);

            Route::group(['prefix' => 'configContract' ], function (){

                Route::get('/{id}', [
                    'as' => 'contracts.configuration',
                    'uses' => 'ContractController@configuration'
                ]);
            });

        });

    });



