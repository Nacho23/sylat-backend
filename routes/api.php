<?php

Route::post('/access-token', 'Api\AccessTokenController@postCollection');

Route::middleware(['access_token'])->group(function () {
    Route::delete('/access-token/{hash}', 'Api\AccessTokenController@deleteResource');
    Route::get('/access-token/{hash}', 'Api\AccessTokenController@getResource');

    Route::get('/user', 'Api\UserController@getCollection');
    Route::post('/user', 'Api\UserController@postCollection');
    Route::patch('/user/{user_uuid}', 'Api\UserController@patchResource');
    Route::delete('/user/{user_uuid}', 'Api\UserController@deleteResource');
    Route::get('/user/{user_uuid}', 'Api\UserController@getResource');
});

Route::options('/{any}', function(){ return ''; })->where('any', '.*');