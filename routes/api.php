<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;

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

Route::post('/login', [LoginController::class, 'index']);
Route::post('/register', [RegisterController::class, 'index']);

Route::get('/testapi/{id}', [ProductController::class, 'detail']);
Route::get('/testapi', [ProductController::class, 'index']);
Route::post('/testapi/create', [ProductController::class, 'create']);
Route::post('/testapi/delete', [ProductController::class, 'delete']);
Route::post('/testapi/update/{id}', [ProductController::class, 'update']);



