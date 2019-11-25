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

Route::group(['prefix' => 'lazycode'], function () {
    Route::apiResources([
        'posts' => 'PostController',
        'categories' => 'CategoryController',
        'users' => 'UserController'
    ]);
    Route::get('users/{id}/posts', 'UserController@userPosts')->name('users.userPosts');
});

