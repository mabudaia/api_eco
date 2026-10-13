<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// routes/web.php
Route::get('/', function() {
    return response()->json([
        'message' => 'Laravel API is working!'
    ]);
});


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){

Route::post('logout',[UserController::class,'logout']);
Route::apiResource('products', ProductController::class);
Route::get('getAllProduct', [ProductController::class,'getAllProduct']);
Route::get('show', [ProductController::class,'show']);
Route::apiResource('orders', OrderController::class);
Route::post('/products/{product}/discount', [ProductController::class, 'applyDiscount']);
Route::apiResource('cart', CartController::class);

Route::apiResource('profile', ProfileController::class);
Route::get('/profileUser',[ UserController::class,'getProfile']);


});
Route::post('products/{productsId}/categories',[ProductController::class, 'addCategoryToProduct']);
Route::get('categories/{CategoryId}/products',[ProductController::class, 'getCategoryProducts']);
Route::get('/health', fn() => ['status' => 'ok']);
