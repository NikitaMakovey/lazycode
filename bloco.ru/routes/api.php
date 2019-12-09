<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // public routes
    Route::post('/login', 'AuthController@login')->name('login.api');
    Route::post('/register', 'AuthController@register')->name('register.api');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'AuthController@logout')->name('logout.api');
    });
});

//Route::post('password/email', 'AuthController@sendResetLinkEmail');
//Route::post('password/reset', 'AuthController@reset');

Route::group(['prefix' => 'code'], function () {
    Route::apiResources([
        'posts' => 'PostController',
        'users' => 'UserController',
    ]);
    Route::get('posts/{post}/comments', 'PostController@postComments');

    Route::get('users/{user}/posts', 'UserController@userPosts');
    Route::get('users/{user}/comments', 'UserController@userComments');

    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category}', 'CategoryController@show');
    Route::post('categories', 'CategoryController@store');
    Route::put('categories/{category}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@destroy');

    Route::get('comments', 'CommentController@index');
    Route::post('comments', 'CommentController@store');
    Route::get('comments/{comment}', 'CommentController@show');
    Route::delete('comments/{comment}', 'CommentController@destroy');

    Route::get('votes', 'VoteController@index');
    Route::post('votes', 'VoteController@store');
    Route::post('votes/delete', 'VoteController@destroy');
});

