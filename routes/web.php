<?php

use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Web\MainController as WebMainController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SafeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth','admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/',[MainController::class,'dashboard'])->name('dashboard');
    Route::middleware('auth')->group(function (){
        Route::resource('users',UserController::class);
        Route::get('users/{user}/medias/edit',[UserController::class,'showUserLinks'])->name('users.medias.edit');
        Route::post('users/{user}/medias/edit',[UserController::class,'updateUserLinks'])->name('users.medias.update');
        Route::get('users/{user}/send',[UserController::class,'sendPageShow'])->name('users.sends.show');
        Route::post('users/{user}/send',[UserController::class,'linkSender'])->name('users.sends.send');
    });
    Route::resource('/medias',MediaController::class);
    Route::resource('/packages',PackageController::class);
    Route::resource('/transactions',TransactionController::class);
    Route::resource('/safes',SafeController::class);
    Route::resource('/payments',PaymentController::class);

    // config routes
    Route::prefix('/config')->group(function () {
        Route::get('/start', [MainController::class, 'startPrj']);
        Route::get('/storageLink', [MainController::class, 'storageLink']);
    });
});
Route::get('/getBuyPackages/{package}',[MainController::class,'getBuyPackage'])->middleware('auth:sanctum');
Route::get('/getVerifyBuyPackages/{payment}',[MainController::class,'getVerifyBuyPackage'])->name('zp.buy_package.verify');
Route::get('/showBankCallBackPage',[MainController::class,'showBankCallBackPage']);
Auth::routes();
Route::get('/',[WebMainController::class,'index']);

