<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::post('register', RegisterController::class);
Route::group(['prefix' => 'auth', 'middleware' => 'api'], function(){
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// Account info
Route::group(['prefix' => 'account', 'middleware' => 'jwt.auth'], function(){
    Route::get('me', 'AccountController@show');
    Route::post('create', 'AccountController@store');
    Route::put('me', 'AccountController@update');
    Route::delete('me', 'AccountController@delete');
});

// Transactions
Route::group(['prefix' => 'transactions', 'middleware' => 'jwt.auth'], function(){
    Route::get('all', 'TransactionController@index');
    Route::get('account/{id}', 'TransactionController@show');
});
Route::post('transaction/new', 'TransactionController@store')->middleware('jwt.auth');
