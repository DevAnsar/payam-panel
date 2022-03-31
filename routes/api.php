<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function (){

    Route::post('/login/send_code', [UserControllerApi::class,'login_send_code']);
    Route::post('/login/mobile', [UserControllerApi::class,'login_with_mobile']);

    Route::group(['middleware' => ['auth:sanctum']],function () {
        Route::post('/send',[SenderController::class,'sendSocialToMobile']);
        Route::prefix('my')->group(function () {
            Route::get('details',[UserControllerApi::class,'getMyDetails']);
            Route::post('details',[UserControllerApi::class,'setMyDetails']);
            Route::get('socials',[UserControllerApi::class,'getMySocials']);
            Route::post('socials',[UserControllerApi::class,'setMySocials']);
            Route::get('sent_box',[UserControllerApi::class,'getSentBox']);
        });
        Route::get('/packages',[UserControllerApi::class,'getPackages']);
    });
});
