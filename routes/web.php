<?php

use App\Http\Controllers\Web\MainController as WebMainController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\SafeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Artisan;
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
//Route::get('/start',[MainController::class,'startPrj']);
//Route::get('/linkstorage', function () {
//    $exitCode = Artisan::call('storage:link', [] );
//    echo $exitCode; // 0 exit code for no errors.
//});

Route::middleware(['auth','admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/',[MainController::class,'dashboard'])->name('dashboard');
    Route::middleware('auth')->group(function (){
        Route::resource('users',UserController::class);
        Route::get('users/{user}/medias/edit',[UserController::class,'showUserLinks'])->name('users.medias.edit');
        Route::post('users/{user}/medias/edit',[UserController::class,'updateUserLinks'])->name('users.medias.update');
    });
    Route::resource('/medias',MediaController::class);
    Route::resource('/packages',PackageController::class);
    Route::resource('/transactions',TransactionController::class);
    Route::resource('/safes',SafeController::class);
});
Route::get('/getBuyPackages/{package}',[MainController::class,'getBuyPackage'])->middleware('auth:sanctum');
Route::get('/getVerifyBuyPackages/{payment}',[MainController::class,'getVerifyBuyPackage'])->name('zp.buy_package.verify');
Auth::routes();
Route::get('/',[WebMainController::class,'index']);

