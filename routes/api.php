<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('v1/categories', CategoryController::class);
Route::apiResource('v1/products' , ProductController::class );
Route::get('v1/products_search' , [ProductController::class , 'search']);

Route::prefix('v1/products/{productId}/reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{reviewId}', [ReviewController::class, 'show']);
    Route::post('/', [ReviewController::class, 'store']);
    Route::put('/{reviewId}', [ReviewController::class, 'update']);
    Route::delete('/{reviewId}', [ReviewController::class, 'destroy']);
});
