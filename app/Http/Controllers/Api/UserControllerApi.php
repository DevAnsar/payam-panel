<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MediaCollection;
use App\Http\Resources\v1\PackageCollection;
use App\Http\Resources\v1\SentBoxCollection;
use App\Models\Media;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class UserControllerApi extends Controller
{
    public function login_send_code(Request $request){

//        return $request->all();
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'messages'=>$validator->messages()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $user = User::where('mobile', $request->mobile)->first();
            if(! $user){
                $user = User::create([
                    'mobile'=>$request->input('mobile'),
                    'password'=>Hash::make($request->mobile),
                ]);
            }

            // Generate login code
            $code = $this->generateRandomNumber(4);
            $message = "کد ورود شما :$code";

            // Sms : login code to device
            $this->sender([$user->mobile],[$message]);

            //
            $user->update([
                'loginCode'=>$code,
                'loginCodeExpire'=>Carbon::now()->addSeconds(60)
            ]);

            return response()->json([
                'status'=>true,
                'messages'=>[
                    'title'=>'کد ورود به شماره موبایل ارسال شد',
                    'code'=>$code,
                ]
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>false,
                'messages'=>$exception->getMessage()
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    public function login_with_mobile(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11',
            'code' => 'required|size:4',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'messages'=>$validator->messages()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $user = User::where('mobile', $request->mobile)->first();

            if (! $user ||  $request->code != $user->loginCode ) {
                return response()->json([
                    'status'=>false,
                    'messages'=>[
                        'title' => 'اطلاعات ورودی صحیح نمیباشد'
                    ]
                ],Response::HTTP_BAD_REQUEST);
            }
            if ($user->loginCodeExpire < Carbon::now()){
                return response()->json([
                    'status'=>false,
                    'messages'=>[
                        'code' => 'کد وارد شده منقضی شده است'
                    ]
                ],Response::HTTP_BAD_REQUEST);
            }

            // Revoke all tokens...
//            $user->tokens()->delete();

            return response()->json([
                'status'=>true,
                'token'=>$user->createToken($request->device_name)->plainTextToken
            ],Response::HTTP_OK);

        }catch (\Exception $exception){
            return response()->json([
                'status'=>false,
                'messages'=>$exception->getMessage()
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    public function getMySocials(Request $request){
        try {
            $user = $request->user();
            $medias = Media::query()->where('status',true)->get();

            return $this->baseJsonResponse([
                'medias'=>  new MediaCollection($medias,$user)
            ],['لیست لینک ها به همراه مقادیر ثبت شده توسط کاربر'],Response::HTTP_OK);

        }catch (\Exception $exception){
            return $this->baseJsonResponse([],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function setMySocials(Request $request){
        try {
            $user = $request->user();
            $res = $this->setUserLink($request->values,$user);
            if ($res){
            return $this->baseJsonResponse([
                'status'=>  true
            ],['لینک ها ثبت شد'],Response::HTTP_OK);
            }else{
                return $this->baseJsonResponse([
                    'status'=>  false
                ],['مشکلی در ثبت لینک ها بوجود آمد'],Response::HTTP_BAD_REQUEST);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse([],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function getPackages(){
        try {
            $packages = Package::query()->where('status',true)->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'packages'=>new PackageCollection($packages)
            ],['لیست پک های پیامکی'],Response::HTTP_OK);
        }catch (\Exception $exception){
            return $this->baseJsonResponse([],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSentBox(Request $request){
        try {
            $user = $request->user();
            $user_sent_box = $user->user_sends()->latest()->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'sent_box'=>new SentBoxCollection($user_sent_box)
            ],['لیست آخرین ارسال ها'],Response::HTTP_OK);
        }catch (\Exception $exception){
            return $this->baseJsonResponse([],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
}
