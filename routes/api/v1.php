<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Middleware\LanguageMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(LanguageMiddleware::class)->group(function () {


    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function () {
            Route::post('/login', 'login');
           
            Route::middleware('auth:sanctum')->group(function () {
                Route::post('/logout', 'logout');
                // Route::get('/user', 'profile')->middleware('can:' . PermissionEnum::VIEW_USERS->value);
                // Route::put('/profile', 'update')->middleware('can:' . PermissionEnum::EDIT_USER->value);
            });
        });


    Route::middleware('auth:sanctum')->group(function () {



        /// auth Product
        // Route::prefix('products')
        //     ->controller(ProductController::class)
        //     ->group(function () {
        //         Route::get('/', 'index')->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value);
        //         Route::get('/{id}', 'show')->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value);
        //         Route::post('/', 'store')->middleware('can:' . PermissionEnum::CREATE_PRODUCT->value);
        //         Route::put('/{id}', 'update')->middleware('can:' . PermissionEnum::EDIT_PRODUCT->value);
        //     });




        /// auth Notification
        Route::prefix('notifications')
            ->controller(NotificationController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::put('/read/{id}', 'markAsRead');
                Route::put('/read-all', 'markAllAsRead');
            });
    });


    // Route::get('/ads-slider', [AdsController::class, 'index']);
    // Route::get('/plans', [PlanController::class, 'index']);
    // Route::get('/faqs', [FaqController::class, 'index']);
    // Route::get('/our-clients', [OurClientController::class, 'index']);
    // Route::post('/contact-us', [ContactUsController::class, 'store']);
});
