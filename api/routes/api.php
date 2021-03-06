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
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

// Account info
Route::group(['prefix' => 'account', 'middleware' => 'jwt.auth'], function(){
    Route::get('me', 'AccountController@show');
    Route::get('setup-intent/{id}', 'AccountController@setupIntent');
    Route::get('card', 'AccountController@getCard');
    Route::post('create', 'AccountController@store');
});

// Transactions
Route::group(['prefix' => 'transactions', 'middleware' => 'jwt.auth'], function(){
    Route::get('all', 'TransactionController@index');
    Route::get('account/{id}', 'TransactionController@show');
    Route::post('new', 'TransactionController@store')->middleware('log.route');
});
