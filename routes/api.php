<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('products', ProductsController::class);

    Route::prefix('cart')->name('carts.')->group(function () {
        Route::get('{cart}', [CartController::class, 'show'])->name('show');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::delete('{cart}', [CartController::class, 'destroy'])->name('destroy');

        Route::prefix('{cart}')->group(function () {
            Route::apiResource('items', ItemsController::class)
                ->except('show');
        });
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
});
