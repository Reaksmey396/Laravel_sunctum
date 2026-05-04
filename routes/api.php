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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return response()->json([
        'smg'=>"hello"
    ]);
});

Route::middleware('throttle:3, 1')->group(function(){   // for throttle:3, 1   is 3 = amount of your register account for 3 times ,  1 = amount of time when you register (3times per a min)
    Route::controller(UserController::class)->group(function(){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
});

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/user', 'user');
        Route::get('/user/{id}', 'getUserById');
    });
    
    Route::controller(ProductController::class)->group(function(){
        Route::post('/addProduct', 'addProduct');
        Route::get('/product', 'getProduct');
        Route::get('/product/{id}', 'getProduct');
    });
});