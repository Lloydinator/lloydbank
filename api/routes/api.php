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


Route::get('accounts', 'AccountController@index');
Route::get('account/{id}', 'AccountController@show');
Route::post('account/create', 'AccountController@store');
Route::put('account/{id}', 'AccountController@update');
Route::delete('account/{id}', 'AccountController@delete');

Route::post('transaction/new', 'TransactionController@store');
Route::get('transactions/account/{id}', 'TransactionController@show');