<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\FuelTypeContrller;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\TransmissionController;
use App\Http\Controllers\TypeOfPackageController;
use App\Http\Controllers\TypeOfShopController;
use App\Http\Controllers\WorkshopController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/user-posts', [AuthController::class, 'getAuthUserPosts']);
});

Route::middleware(['api'])->group(function () {
    Route::resource('fuel-types', FuelTypeContrller::class)->except(['create', 'edit']);
    Route::resource('brands', BrandController::class)->except(['create', 'edit']);
    Route::resource('transmissions', TransmissionController::class)->except(['create', 'edit']);
    Route::resource('type-of-shopes', TypeOfShopController::class)->except(['create', 'edit']);
    Route::resource('type-of-packages', TypeOfPackageController::class)->except(['create', 'edit']);
    Route::resource('payment-methods', PaymentMethodController::class)->except(['create', 'edit']);
    Route::resource('car-models', CarModelController::class)->except(['create', 'edit']);
    Route::resource('posts', PostController::class)->except(['create', 'edit']);
    Route::resource('subscription-packages', SubscriptionPackageController::class)->except(['create', 'edit']);
    Route::resource('cars', CarController::class)->except(['create', 'edit']);
    Route::resource('car-models', CarModelController::class)->except(['create', 'edit']);
    Route::resource('agencies', AgencyController::class)->except(['create', 'edit']);
    Route::resource('workshops', WorkshopController::class)->except(['create', 'edit']);
});
