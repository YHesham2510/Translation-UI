<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\TranslateUserController;
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

// Route::get('/', function () {
//     return view('login');
// });
// Route::get('/home', [Controller::class, 'index'])->name('home');
// Route::get("/home",function(){
//     return view("home");
// });

// Auth::routes();
Route::get('/api/translation', [TranslateUserController::class, 'index'])->name('translation.index')->middleware('auth');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

