<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthApiController extends Controller
{
    private int $loginCodeLifeSecond = 60;

    /**
     * send login code to user mobile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_send_code(Request $request){
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11',
        ]);

        if ($validator->fails()) {
            return $this->baseJsonResponse(['status'=>false],['validator_errors'=>$validator->messages()]);
        }

        try{
            $user = User::where('mobile', $request->mobile)->first();
            if(! $user){
                $user = User::create([
                    'mobile'=>$request->input('mobile'),
                    'password'=>Hash::make($request->mobile),
                    'completed'=>false,
                ]);
            }

            // Generate login code
            $code = $this->generateRandomNumber(4);
            $message = "کد ورود شما به پیامکسازی :$code";

            // Sms : login code to device
            $result = $this->sender([$user->mobile],[$message]);

            if ($result['isSuccessful']){
                $user->update([
                    'loginCode'=>$code,
                    'loginCodeExpire'=>Carbon::now()->addSeconds($this->loginCodeLifeSecond)
                ]);

                return $this->baseJsonResponse(['status'=>true],[
                    'title'=>'کد ورود به شماره موبایل ارسال شد',
                    'description'=>"کد تا $this->loginCodeLifeSecond  ثانیه معتبر میباشد",
                    'message'=>$message,
                ]);
            }else{
                return $this->baseJsonResponse(['status'=>false],["message"=>"ارسال پیامک با مشکل از طرف ارائه دهنده خدمات مواجه شد"],Response::HTTP_CONFLICT);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[
                $exception->getMessage()
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

    }

    /**
     * send login code and mobile for return auth token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_with_mobile(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11',
            'code' => 'required|size:4',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->baseJsonResponse(['status'=>false],[
                $validator->messages()
            ]);
        }

        try{
            $user = User::where('mobile', $request->mobile)->first();

            if (! $user ||  $request->code != $user->loginCode ) {
                return $this->baseJsonResponse(['status'=>false],[
                    'title' => 'اطلاعات ورودی صحیح نمیباشد'
                ]);
            }
            if ($user->loginCodeExpire < Carbon::now()){
                return $this->baseJsonResponse(['status'=>false],[
                    'title' => 'کد وارد شده منقضی شده است'
                ]);
            }

            // gift sms for new user when he/she register not completed
            if (!$user->register_completed && false){
                //bug this below code -> we should add package to new user account
//                $smsTariff = $this->getSmsTariff();
//                $smsCountForNewUser = $this->getSafe('newUserSmsCount');
//                if ($smsCountForNewUser && $smsCountForNewUser > 0){
                $user->update([
                    'register_completed'=>true,
//                       'account_balance' => $user->account_balance + ($smsCountForNewUser * $smsTariff)
                ]);
//                }
            }

            // Revoke all tokens...
//            $user->tokens()->delete();

            return $this->baseJsonResponse([
                'status'=>true,
                'token'=>$user->createToken($request->device_name)->plainTextToken
            ],[]);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(
                ['status'=>false],
                [$exception->getMessage()],
                ResponseAlias::HTTP_BAD_REQUEST);

        }

    }
}
