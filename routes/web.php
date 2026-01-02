<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\{
    AdminAuthController,
    InstitutesController,
    SubscriptionPlanController,
    InstituteSubscriptionsController
};

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/home', 'index');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTH (GUEST ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest:admin')->controller(AdminAuthController::class)->group(function () {
        Route::get('/', 'login');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'postLogin')->name('login.post');

        Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
        Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');

        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('reset-password', 'submitResetPasswordForm')->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD & PROFILE
        |--------------------------------------------------------------------------
        */
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('dashboard', 'adminDashboard')->name('dashboard');

            Route::get('profile', 'adminProfile')->name('profile');
            Route::post('profile', 'updateAdminProfile')->name('update.profile');

            Route::get('change-password', 'changePassword')->name('change.password');
            Route::post('change-password', 'updatePassword')->name('update.password');

            Route::post('logout', 'logout')->name('logout');
        });

        /*
        |--------------------------------------------------------------------------
        | INSTITUTES MODULE
        |--------------------------------------------------------------------------
        */
        Route::prefix('institutes')->name('institutes.')->controller(InstitutesController::class)->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');

            Route::get('all', 'getAll')->name('getall');
            Route::get('{id}', 'get')->name('show');

            Route::post('/', 'store')->name('store');
            Route::put('{id}', 'update')->name('update');

            Route::post('status', 'status')->name('status');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTION PLANS MODULE
        |--------------------------------------------------------------------------
        */
        Route::prefix('subscription-plans')->name('subscription.plans.')->controller(SubscriptionPlanController::class)->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');

            Route::get('all', 'getAll')->name('getall');
            Route::get('{id}', 'get')->name('show');

            Route::post('/', 'store')->name('store');
            Route::post('{id}', 'update')->name('update');

            Route::post('status', 'status')->name('status');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });


        /*
        |--------------------------------------------------------------------------
        | INSTITUTE SUBSCRIPTIONS MODULE
        |--------------------------------------------------------------------------
        */
        Route::prefix('institute-subscriptions')->name('institute.subscriptions.')->controller(InstituteSubscriptionsController::class)->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');

            Route::get('all', 'getAll')->name('getall');
            Route::get('{id}', 'get')->name('show');

            Route::post('/', 'store')->name('store');
            Route::post('update/{id}', 'update')->name('update');

            Route::post('status', 'status')->name('status');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });
    });
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES (FUTURE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // future user routes
});
