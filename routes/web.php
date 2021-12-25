<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccountController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// Account info
Route::group(['prefix' => 'account', 'middleware' => 'auth'], function(){
    Route::get('me', [AccountController::class, 'show']);
    Route::get('setup-intent/{id}', [AccountController::class, 'setupIntent']);
    Route::get('card', [AccountController::class, 'getCard']);
    Route::post('create', [AccountController::class, 'store']);
});
/*
// Transactions
Route::group(['prefix' => 'transactions', 'middleware' => 'auth'], function(){
    Route::get('all', 'TransactionController@index');
    Route::get('account/{id}', 'TransactionController@show');
    Route::post('new', 'TransactionController@store');
});
*/