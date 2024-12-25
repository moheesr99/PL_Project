<?php
//
//use App\Http\Controllers\Auth\AuthenticatedSessionController;
//use App\Http\Controllers\Auth\RegisteredUserController;
//
//use App\Http\Controllers\CartController;
//use App\Http\Controllers\ProductController;
//use App\Http\Controllers\SearchController;
//use App\Http\Controllers\StoreController;
//use Illuminate\Support\Facades\Request;
//use Illuminate\Support\Facades\Route;
//
//Route::get('/register',[RegisteredUserController::class, 'store']);
//
//Route::get('/login',[AuthenticatedSessionController::class, 'store']);
//Route::post('/logout',[AuthenticatedSessionController::class, 'destroy'])->middleware('auth');
//
//Route::get('/stores',[StoreController::class, 'index'])->middleware('auth');
//Route::get('/stores/{store}',[StoreController::class, 'show'])->middleware('auth');
//
//Route::get('/products/{product}',[ProductController::class, 'show'])->middleware('auth');
//
//Route::get('/search',[SearchController::class, 'search'])->middleware('auth');
//
//Route::get('/cart',[CartController::class, 'index'])->middleware('auth');
//Route::post('/cart',[CartController::class, 'store'])->middleware('auth');
//Route::delete('/cart/{cart}',[CartController::class, 'destroy'])->middleware('auth');
//Route::put('/cart/{cart}',[CartController::class, 'update'])->middleware('auth');


use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [RegisteredUserController::class, 'store']); // POST is standard for creating new resources
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // POST is standard for login

// Authenticated Routes (Protected by Sanctum Middleware)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Store Routes
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/stores/{store}', [StoreController::class, 'show']);

    // Product Routes
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Search Routes
    Route::get('/search', [SearchController::class, 'search']);

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{cart}', [CartController::class, 'destroy']);
    Route::put('/cart/{cart}', [CartController::class, 'update']);

    // Favorites Routes
    Route::get('/favorite',[FavoritesController::class, 'index']);
    Route::post('/favorite',[FavoritesController::class, 'store']);
    Route::delete('/favorite/{favorite}', [FavoritesController::class, 'destroy']);
});


    // Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Store routes
    Route::post('/admin/stores', [AdminStoreController::class, 'store']);
    Route::delete('/admin/stores/{id}', [AdminStoreController::class, 'destroy']);

    // Product routes
    Route::post('/admin/products', [AdminProductController::class, 'store']);
    Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy']);
    Route::delete('/admin/products/{id}', [AdminProductController::class, 'update']);
});

