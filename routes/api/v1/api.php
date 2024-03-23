<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//all routes / api here must be api authenticated

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('login', 'PassportAuthController@login');
    });

    Route::group(['prefix' => 'ToDo','middleware'=>'auth:sanctum'], function () {
        Route::get('/', 'ToDoController@index');
        Route::get('/add', 'ToDoController@add');

    });


});
