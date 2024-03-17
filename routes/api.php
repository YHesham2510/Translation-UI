<?php

use App\Models\TranslateUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TranslateUserController;
use App\Http\Controllers\ApiController;



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
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});
Route::get("/translation", [TranslateUserController::class, 'index']);
Route::post('/update-text/{id}', [ApiController::class, 'updateText']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

