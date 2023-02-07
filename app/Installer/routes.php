<?php

Route::group(
    ['middleware' => ['web'], 'prefix' => 'installer', 'namespace' => 'App\Installer\Controllers'],
    function () {
        Route::get('welcome', 'HomeController@index');
        Route::get('permissions', 'PermissionsController@index');
        Route::get('database', 'DatabaseController@index');
        Route::post('database', 'DatabaseController@post');
        Route::get('finish', 'DatabaseController@finish');

        Route::get('update', 'UpdateController@update');
        Route::get('update_init',  'UpdateController@update_init');
    }
);
