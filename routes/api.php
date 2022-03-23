<?php

use App\Http\Controllers\Api\SenderController;
use App\Http\Controllers\Api\UserControllerApi;
use App\lib\SMSIR\SmsIRClient;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/users',[SenderController::class,'send']);

Route::post('/login/send_code', [UserControllerApi::class,'login_send_code']);
Route::post('/login/mobile', [UserControllerApi::class,'login_with_mobile']);

Route::get('/send',function (){
    $smsir = new SmsIRClient(env('SMSIR_API_KEY'), env('SMSIR_SECRET_KEY'), env('SMSIR_LINE_NUMBER'));
    return $smsir->sendVerificationCode('1234','09036587580');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/sendSocial',[SenderController::class,'sendSocialToMobile']);
});
