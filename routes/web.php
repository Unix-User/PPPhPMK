<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PortfolioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// 
Route::get('/', function () {
    return view('landing');
});

// get status on url and render view notification passing the status
Route::get('/notification/{status}', function ($status) {
    return view('notification', ['status' => $status]);
});


Route::controller(UserController::class)->group(function () {
    Route::get('user/create', 'create');
    Route::post('user/store', 'store');
    Route::middleware('auth')->group(function () {
        Route::get('users', 'index');
        Route::get('user/{id}/show', 'show');
        // route for payment
        Route::get('user/{id}/payment', 'payment');
        Route::get('user/{id}/edit', 'edit');
        Route::post('user/{id}/update', 'update');
        Route::get('user/{id}/delete', 'delete');
    });
    Route::get('login', 'login')->name('login');
    Route::get('user/recovery', 'recovery');
    Route::post('user/reset', 'reset');
    Route::get('user/reset/{token}', 'resetPassword')->name('renew');
    Route::post('user/finish/{token}', 'finish');
    Route::post('login/auth', 'authenticate');
    Route::get('logout', 'logout')->name('logout');
});
// if user is logged in, show the following routes

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('product/{id}/show', 'show');
    // route for the user to buy a product
    Route::middleware('auth')->group(function () {
        
        Route::get('product/create', 'create');
        Route::post('product/store', 'store');
        Route::get('product/{id}/edit', 'edit');
        Route::post('product/{id}/update', 'update');
        Route::get('product/{id}/select', 'select');
        Route::get('product/{id}/delete', 'delete');
    });
});

Route::controller(DeviceController::class)->group(function () {
    Route::middleware('auth')->group(function () {
    Route::get('devices', 'index');
    Route::get('device/create', 'create');
    Route::post('device/store', 'store');
    Route::get('device/{id}', 'show');
    Route::get('device/{id}/edit', 'edit');
    Route::post('device/{id}/update', 'update');
    Route::get('device/{id}/delete', 'delete');
    });
});

Route::controller(PortfolioController::class)->group(function () {
    Route::get('/isp', 'isp');
    Route::get('/development', 'development');
    Route::get('/contact', 'contact');
    Route::post('/send', 'send');
});
