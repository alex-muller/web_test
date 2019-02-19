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

Route::post(config('app.api_prefix').'/auth/login', 'Api\User\AuthController@login');


Route::get('/{route}', function () {
    return view('layouts.default');
})->where('route', '[A-Za-z0-9_\/-]*');