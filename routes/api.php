<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\SenderController;
use App\Http\Controllers\Api\UserControllerApi;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function (){
    Route::prefix('login')->group(function () {
        Route::post('send_code', [AuthApiController::class, 'login_send_code']);
        Route::post('mobile', [AuthApiController::class, 'login_with_mobile']);
    });
    Route::group(['middleware' => ['auth:sanctum']],function () {
        Route::post('/send',[SenderController::class,'sendSocialToMobile']);
        Route::prefix('my')->group(function () {
            Route::get('details',[UserControllerApi::class,'getMyDetails']);
            Route::post('details',[UserControllerApi::class,'setMyDetails']);
            Route::get('socials',[UserControllerApi::class,'getMySocials']);
            Route::post('socials/edit',[UserControllerApi::class,'setMySocials']);
            Route::get('sent_box',[UserControllerApi::class,'getSendBox']);
            Route::get('packages',[UserControllerApi::class,'getMyPackages']);
            Route::get('tokens',[UserControllerApi::class,'getMyTokens']);
            Route::delete('tokens/{id}',[UserControllerApi::class,'deleteMyToken']);
            Route::delete('deleteOtherTokens',[UserControllerApi::class,'deleteAllOtherMyTokens']);
        });
        Route::get('/packages',[PackageApiController::class,'getPackages']);
        Route::get('/packages/{package}',[PackageApiController::class,'getPackage']);
    });
});
