<?php

use Illuminate\Http\Request;
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

Route::get('accounts/all', 'AccountController@index');
Route::prefix('account')->group(function(){
    Route::get('{id}', 'AccountController@show');
    Route::post('create', 'AccountController@store');
    Route::put('{id}', 'AccountController@update');
    Route::delete('{id}', 'AccountController@delete');
});

Route::prefix('transactions')->group(function(){
    Route::get('all', 'TransactionController@index');
    Route::get('account/{id}', 'TransactionController@show');
});
Route::post('transaction/new', 'TransactionController@store');
