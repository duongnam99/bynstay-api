<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Admin\HostController;
use App\Http\Controllers\API\Admin\ClientController;
use App\Http\Controllers\API\Admin\HomestayController;
use App\Http\Controllers\API\Admin\HomeStayTypeController;
use App\Http\Controllers\API\Admin\HomestayPolicyController;
use App\Http\Controllers\API\Admin\HomestayUtilityController;
use App\Http\Controllers\API\Admin\HomestayPolicyTypeController;
use App\Http\Controllers\API\Common\HSUtilityController;
use App\Http\Controllers\API\Common\HSPriceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'users']);

    Route::prefix('admin')->group(function () {
        Route::resource('homestay', HomestayController::class);

        Route::resource('homestay-utility-type', HomestayUtilityController::class);
        Route::get('homestay-utility-type-parents', [HomestayUtilityController::class, 'getParents']);
        Route::get('homestay-utility-type/get-list-child/{id}', [HomestayUtilityController::class, 'getListChildbyId']);

        Route::resource('homestay-type', HomeStayTypeController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('hosts', HostController::class);
        Route::resource('homestay-policy-type', HomestayPolicyTypeController::class);
    });

    Route::prefix('common')->group(function () {
        Route::resource('homestay-policy', HomestayPolicyController::class);
        Route::resource('homestay-utility', HSUtilityController::class);
        Route::resource('homestay-price', HSPriceController::class);
    });


});
