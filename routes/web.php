<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('users/get-states', [UserController::class, 'getStates'])->name('users.get_states');
Route::get('users/get-cities', [UserController::class, 'getCities'])->name('users.get_cities');
Route::resource('users', UserController::class);
