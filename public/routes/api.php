<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/ping', function (Request $request) {
    return response()->json(['message' => 'Сервис работает']);
});

Route::get('/user/info', [UserController::class, 'show']);

Route::post('/user/create', [UserController::class, 'store']);
