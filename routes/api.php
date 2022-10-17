<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('/store', [ProductController::class, 'store']);

    Route::put('/update/{id}', [ProductController::class, 'update']);

    Route::delete('/products/{id}', [ProductController::class, 'delete']);

    Route::post('/logout', [UserController::class, 'logout']);
});


//Public routes


Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/search/{name}', [ProductController::class, 'search']);

Route::get('/products', [ProductController::class, 'index']);


