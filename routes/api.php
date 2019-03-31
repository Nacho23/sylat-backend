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

    Route::patch('/user/{user_uuid}/associate', 'Api\UserController@patchUnitResource');

    Route::get('/unit', 'Api\UnitController@getCollection');
    Route::post('/unit', 'Api\UnitController@postCollection');
    Route::patch('/unit/{unit_uuid}', 'Api\UnitController@patchResource');
    Route::delete('/unit/{unit_uuid}', 'Api\UnitController@deleteResource');
    Route::get('/unit/{unit_uuid}', 'Api\UnitController@getResource');

    Route::get('/category', 'Api\CategoryController@getCollection');
    Route::post('/category', 'Api\CategoryController@postCollection');
    Route::delete('/category/{category_id}', 'Api\CategoryController@deleteResource');

    Route::get('/news', 'Api\NewsController@getCollection');
    Route::post('/news', 'Api\NewsController@postCollection');
    Route::patch('/news/{new_uuid}', 'Api\NewsController@patchResource');
    Route::delete('/news/{new_uuid}', 'Api\NewsController@deleteResource');
    Route::get('/news/{new_uuid}', 'Api\NewsController@getResource');

    Route::get('/unit/{unit_id}/question', 'Api\Unit\QuestionController@getCollection');
    Route::post('/unit/{unit_id}/question', 'Api\Unit\QuestionController@postCollection');
    Route::patch('/question/{question_id}', 'Api\Unit\QuestionController@patchResource');
    Route::delete('/question/{question_id}', 'Api\Unit\QuestionController@deleteResource');
    Route::get('/question/{question_id}', 'Api\Unit\QuestionController@getResource');

    Route::get('/unit/{unit_id}/message', 'Api\Unit\MessageController@getCollection');
    Route::post('/unit/{unit_id}/message', 'Api\Unit\MessageController@postCollection');
    Route::get('/message/{message_uuid}', 'Api\Unit\MessageController@getResource');

    Route::post('/unit/{unit_id}/import', 'Api\Unit\ImportController@postCollection');
});

Route::options('/{any}', function(){ return ''; })->where('any', '.*');