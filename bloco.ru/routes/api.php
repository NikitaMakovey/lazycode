<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['json.response']], function () {

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');

        Route::group(['prefix' => 'edit'], function () {
            Route::put('main', 'EditController@main');
            Route::put('image', 'EditController@image');
            Route::put('email', 'EditController@email');
            Route::put('bio', 'EditController@bio');
        });

        Route::group(['prefix' => 'v1'], function () {
            Route::post('posts', 'PostController@store');
            Route::delete('posts/{id}', 'PostController@destroy');
            Route::put('posts/{id}', 'PostController@update');

            Route::post('comments', 'CommentController@store');
            Route::delete('comments/{id}', 'CommentController@destroy');

            Route::post('votes', 'VoteController@store');
        });
    });

    Route::group(['prefix' => 'v1'], function () {
        Route::get('categories', 'CategoryController@index');
        Route::get('categories/{slug}', 'CategoryController@show');
        Route::post('categories', 'CategoryController@store');
        Route::delete('categories/{id}', 'CategoryController@destroy');

        Route::get('posts', 'PostController@index');
        Route::get('posts/{id}', 'PostController@show');

        Route::get('comments', 'CommentController@index');

        Route::get('users', 'UserController@index');
        Route::get('users/{id}', 'UserController@show');
        Route::get('users/{id}/posts', 'UserController@posts');
        Route::get('users/{id}/comments', 'UserController@comments');
    });
});
