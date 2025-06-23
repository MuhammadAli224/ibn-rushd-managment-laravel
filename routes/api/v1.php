
<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\Api\V1\AdsController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BranchController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ClientUserController;
use App\Http\Controllers\Api\V1\ContactUsController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OurClientController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Middleware\LanguageMiddleware;
use App\Models\OurClient;
use Illuminate\Support\Facades\Route;

Route::middleware(LanguageMiddleware::class)->group(function () {


    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function () {
            Route::post('/login', 'login');
            Route::post('/register-client', 'clientRegister');
            Route::middleware('auth:sanctum')->group(function () {
                Route::post('/logout', 'logout');
                Route::get('/user', 'profile')->middleware('can:' . PermissionEnum::VIEW_USERS->value);
                Route::put('/profile', 'update')->middleware('can:' . PermissionEnum::EDIT_USER->value);
            });
        });


    Route::middleware('auth:sanctum')->group(function () {


        /// auth Branch
        Route::prefix('branches')
            ->controller(BranchController::class)
            ->group(function () {
                Route::get('/', 'index')->middleware('can:' . PermissionEnum::VIEW_BRANCHES->value);
                Route::get('/{id}', 'show')->middleware('can:' . PermissionEnum::VIEW_BRANCHES->value);
                Route::post('/{id}', 'update')->middleware('can:' . PermissionEnum::EDIT_BRANCH->value);
            });

        /// auth Product
        Route::prefix('products')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('/', 'index')->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value);
                Route::get('/{id}', 'show')->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value);
                Route::post('/', 'store')->middleware('can:' . PermissionEnum::CREATE_PRODUCT->value);
                Route::put('/{id}', 'update')->middleware('can:' . PermissionEnum::EDIT_PRODUCT->value);
            });

        /// auth Category
        Route::prefix('categories')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->middleware('can:' . PermissionEnum::VIEW_CATEGORIES->value);
                Route::post('/', 'store')->middleware('can:' . PermissionEnum::CREATE_CATEGORY->value);
                Route::put('/{category}', 'update')->middleware('can:' . PermissionEnum::EDIT_CATEGORY->value);
            });


        /// auth Home
        Route::prefix('home')
            ->controller(HomeController::class)
            ->group(function () {
                Route::get('/counts', 'counts');
            });


        /// auth Notification
        Route::prefix('notifications')
            ->controller(NotificationController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::put('/read/{id}', 'markAsRead');
                Route::put('/read-all', 'markAllAsRead');
            });

        /// auth subscription
        Route::prefix('subscriptions')
            ->controller(SubscriptionController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'subscribe');
            });

        /// auth client branch
        Route::prefix('client-users')
            ->controller(ClientUserController::class)
            ->group(function () {
                Route::get('/', 'index')->middleware('can:' . PermissionEnum::VIEW_USERS->value);

                Route::post('/register-user-client', 'registerUserClient')
                    ->middleware('check.permissions:' . implode(',', [
                        PermissionEnum::CREATE_USER->value,
                        PermissionEnum::EDIT_USER->value,
                    ]));

                Route::put('/{id}', 'updateUserClient')
                    ->middleware('can:' . PermissionEnum::EDIT_USER->value);
            });
    });


    Route::get('/ads-slider', [AdsController::class, 'index']);
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::get('/our-clients', [OurClientController::class, 'index']);
    Route::post('/contact-us', [ContactUsController::class, 'store']);
});
