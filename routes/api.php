<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CatagoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Auth
Route::post('/login', [AuthController::class, 'login']);

// Protected route example
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/brand/search/{id}', [BrandController::class, 'show']);

// Catagories
Route::get('/catagories', [CatagoryController::class, 'index']);
Route::get('/catagories/search/{slug}', [CatagoryController::class, 'show']);

Route::apiResource('products', ProductController::class);
