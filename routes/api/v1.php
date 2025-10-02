<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\LessonsController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\FcmController;
use App\Http\Middleware\LanguageMiddleware;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;

Route::middleware(LanguageMiddleware::class)->group(function () {


    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function () {
            Route::post('/login', 'login');

            Route::middleware('auth:sanctum')->group(function () {
                Route::post('/logout', 'logout');
            });
        });


    Route::middleware('auth:sanctum')->group(function () {


        /// auth Home
        Route::prefix('home')
            ->controller(HomeController::class)
            ->group(function () {
                Route::get('/', 'index');
                // ->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value);
            });

        Route::prefix('wallet')
            ->controller(WalletController::class)
            ->group(function () {
                Route::get('/', 'index');
            });




        /// auth Notification
        Route::prefix('notifications')
            ->controller(NotificationController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::put('/read/{id}', 'markAsRead');
                Route::put('/read-all', 'markAllAsRead');
            });

        Route::prefix('lessons')
            ->controller(LessonsController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'show');
            });
    });


    Route::post('/test-fcm', [FcmController::class, 'sendFcmNotification']);
    // Route::get('/plans', [PlanController::class, 'index']);
    // Route::get('/faqs', [FaqController::class, 'index']);
    // Route::get('/our-clients', [OurClientController::class, 'index']);
    // Route::post('/contact-us', [ContactUsController::class, 'store']);
});
