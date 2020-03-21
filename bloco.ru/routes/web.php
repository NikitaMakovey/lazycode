<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('uploads/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path('app').'/'.$folder.'/'.$filename;

    //return response($path, 200);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('{any?}', function () {
    return view('index');
})->where('any', '.*');
