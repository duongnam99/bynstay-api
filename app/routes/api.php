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
use App\Http\Controllers\API\Common\HsCheckoutController;
use App\Http\Controllers\API\Common\HSImageController;
use App\Http\Controllers\API\Common\HsOrderController;
use App\Http\Controllers\API\Common\HSUtilityController;
use App\Http\Controllers\API\Common\HSPriceController;
use App\Http\Controllers\API\Common\LocationController;
use App\Http\Controllers\API\Customer\WishListController;

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


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('update-pw', [RegisterController::class, 'updatePassword']); 
    Route::post('user/edit', [RegisterController::class, 'edit']); 

    Route::get('/users', [UserController::class, 'users']);
    Route::prefix('admin')->group(function () {
        Route::resource('ad-homestay', HomestayController::class);
        Route::resource('ad-homestay-type', HomeStayTypeController::class);

        Route::resource('homestay-utility-type', HomestayUtilityController::class);

        Route::get('homestay-utility-type-parents', [HomestayUtilityController::class, 'getParents']);
        Route::get('homestay-utility-type/get-list-child/{id}', [HomestayUtilityController::class, 'getListChildbyId']);

        Route::resource('clients', ClientController::class);
        Route::resource('hosts', HostController::class);
        Route::resource('homestay-policy-type', HomestayPolicyTypeController::class);
    });

    Route::prefix('common')->group(function () {
        Route::resource('homestay', HomestayController::class);
        Route::resource('homestay-type', HomeStayTypeController::class);
        Route::resource('homestay-policy', HomestayPolicyController::class);
        Route::get('homestay-policy-full/{id}', [HomestayPolicyController::class, 'getFull']);

        Route::resource('homestay-utility', HSUtilityController::class);
        Route::get('hs-util/{id}', [HSUtilityController::class, 'getHsUtil']);
        Route::get('homestay-utility-parent', [HSUtilityController::class, 'getUtilityParent']);
        Route::get('homestay-utility-parent/{id}', [HSUtilityController::class, 'getUtilityChildByParent']);
        Route::get('homestay-utility-children', [HSUtilityController::class, 'getUtilityChild']);

        Route::resource('homestay-price', HSPriceController::class);
        Route::get('get-homestay-price/{hs_id}', [HSPriceController::class, 'getHsPrice']);
        Route::put('update-homestay-price/{id}', [HSPriceController::class, 'updateByHomestayId']);
        Route::resource('homestay-image', HSImageController::class);
        // get hometay image
        Route::get('get-homestay-image/{hs_id}', [HSImageController::class, 'getHsImage']);
        Route::prefix('location')->group(function () {
            Route::get('district', [LocationController::class, 'getDistrict']);
            Route::get('district/{id}', [LocationController::class, 'getWardByDistrict']);
            Route::get('province', [LocationController::class, 'getProvince']);
            Route::get('province/{id}', [LocationController::class, 'getDistrictByProvince']);
            Route::get('ward', [LocationController::class, 'getWard']);
        });

        Route::get('customer-by-host', [HsOrderController::class, 'getCustomerByHost']);
        Route::get('order-host', [HsOrderController::class, 'getOrderByHost']);
        Route::put('homestay-order/{id}', [HsOrderController::class, 'update']);

    });
    
    Route::prefix('cus')->group(function () {
        Route::get('my-order', [HsOrderController::class, 'getCustomerOrder']);
        Route::resource('wishlist', WishListController::class);
        Route::get('wishlist-hs', [WishListController::class, 'getHs']);
        Route::get('del-wishlist-hs/{id}', [WishListController::class, 'deleteWishHs']);
        Route::get('check-wished/{id}', [WishListController::class, 'checkWished']);
    });

});

Route::prefix('pub')->group(function () {
    Route::get('get-homestay-image/{hs_id}', [HSImageController::class, 'getHsImage']);
    Route::get('get-homestay-price/{hs_id}', [HSPriceController::class, 'getHsPrice']);

    Route::get('hs-util/{id}', [HSUtilityController::class, 'getHsUtil']);
    Route::get('homestay/{id}', [HomestayController::class, 'show']);
    Route::get('homestay-type', [HomeStayTypeController::class, 'index']);
    Route::get('homestay-type/{id}', [HomeStayTypeController::class, 'show']);

    Route::get('homestay-policy-full/{id}', [HomestayPolicyController::class, 'getFull']);
    Route::post('homestay-order', [HsOrderController::class, 'store']);
    Route::get('homestay-order/{id}', [HsOrderController::class, 'show']);
    Route::get('homestay-ordered-time/{id}', [HsOrderController::class, 'orderTime']);

    Route::get('homestay-suggested', [HomestayController::class, 'suggested']);
    Route::get('place-suggested', [LocationController::class, 'suggested']);

    Route::get('search-place', [LocationController::class, 'search']);
    Route::get('hs-by-place', [HomestayController::class, 'getByPlace']);

    Route::get('homestay-utility-type-parents', [HomestayUtilityController::class, 'getParents']);
    Route::post('sort-hs', [HSPriceController::class, 'sortByPrice']);
    Route::post('filter-hs-type', [HomestayController::class, 'filterHsType']);
    Route::post('filter-hs-util', [HSUtilityController::class, 'filterUtil']);
    Route::get('homestay', [HomestayController::class, 'index']);


});

Route::prefix('payment')->group(function () {
    Route::post('homestay-checkout', [HsCheckoutController::class, 'fasterPayCheckout']);
    Route::post('fp-pingback', [HsCheckoutController::class, 'pingback']);
});

