<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

Route::get('yandex', 'YandexController@index');

Route::group(['middleware' => ['json.response']], function () {

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

    Route::group(['prefix' => 'reset'], function () {
        Route::post('email', 'MailController@sendResetEmail');
        Route::post('password', 'AuthController@reset');
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
        Route::get('/verify', 'AuthController@isAdmin');
        Route::get('/email/confirm', 'MailController@sendConfirmationEmail');
        Route::post('/email/confirm', 'AuthController@confirmEmail');

        Route::group(['prefix' => 'uploads'], function () {
            Route::post('image', 'FileEntryController@uploadFile');
        });

        Route::group(['prefix' => 'edit'], function () {
            Route::put('main', 'EditController@main');
            Route::put('image', 'EditController@image');
            Route::put('email', 'EditController@email');
            Route::put('bio', 'EditController@bio');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('publish', 'UserController@publish');
            Route::get('process', 'UserController@process');
            Route::get('reject', 'UserController@reject');
            Route::get('draft', 'UserController@draft');
        });

        Route::group(['prefix' => 'v1'], function () {
            Route::get('edit-posts/{id}', 'PostController@edit');
            Route::get('draft-posts/{id}', 'PostController@draft_edit');

            Route::get('auth-posts/{id}', 'PostController@auth_show');
            Route::post('posts', 'PostController@store');
            Route::post('draft', 'PostController@draft');

            Route::delete('posts/{id}', 'PostController@destroy');
            Route::delete('draft/{id}', 'PostController@delete_draft');

            Route::put('posts/{id}', 'PostController@update');
            Route::put('draft/{id}', 'PostController@update_draft');

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
                Route::get('admin/posts', 'AdminController@index');

                Route::get('admin/edit-posts/{id}', 'AdminController@update');
                Route::delete('admin/edit-posts/{id}', 'AdminController@destroy');
                Route::get('admin/edits/{id}', 'AdminController@edit');
                Route::get('admin/edit-posts', 'AdminController@edit_posts');
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
