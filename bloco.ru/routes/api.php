<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['json.response']], function () {

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
        Route::get('/verify', 'AuthController@isAdmin');

        Route::group(['prefix' => 'edit'], function () {
            Route::put('main', 'EditController@main');
            Route::put('image', 'EditController@image');
            Route::put('email', 'EditController@email');
            Route::put('bio', 'EditController@bio');
        });

        Route::group(['prefix' => 'v1'], function () {
            Route::post('posts', 'PostController@store');
            Route::post('draft', 'PostController@draft');
            Route::delete('posts/{id}', 'PostController@destroy');
            Route::put('posts/{id}', 'PostController@update');

            Route::post('comments', 'CommentController@store');
            Route::delete('comments/{id}', 'CommentController@destroy');

            Route::post('votes', 'VoteController@store');

            Route::post('subs/{id}', 'SubscriptionController@store');
            Route::delete('subs/{id}', 'SubscriptionController@destroy');

            Route::group(['middleware' => 'admin.request'], function () {
                Route::post('categories', 'CategoryController@store');
                Route::delete('categories/{id}', 'CategoryController@destroy');

                Route::post('tags', 'TagController@store');
                Route::delete('tags/{id}', 'TagController@destroy');

                Route::get('refresh-vote-types', 'VoteController@refresh');

                Route::get('confirm/{id}', 'AdminController@confirm');
                Route::get('reject/{id}', 'AdminController@reject');
            });
        });
    });

    Route::group(['prefix' => 'v1'], function () {
        Route::get('categories', 'CategoryController@index');
        Route::get('rating', 'CategoryController@rating');
        Route::get('categories/{slug}', 'CategoryController@show');

        Route::get('posts', 'PostController@index');
        Route::get('posts/{id}', 'PostController@show');

        Route::get('comments', 'CommentController@index');

        Route::get('users', 'UserController@index');
        Route::get('users/{id}', 'UserController@show');
        Route::get('users/{id}/posts', 'UserController@posts');
        Route::get('users/{id}/comments', 'UserController@comments');

        Route::get('tags', 'TagController@index');

        Route::get('users/{id}/subscribers', 'SubscriptionController@subscribers');
        Route::get('users/{id}/subscriptions', 'SubscriptionController@subscriptions');
    });
});
