<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MediaCollection;
use App\Http\Resources\v1\PackageCollection;
use App\Http\Resources\v1\SentBoxCollection;
use App\Http\Resources\v1\UserResource;
use App\Models\Media;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserControllerApi extends Controller
{
    private int $loginCodeLifeSecond = 60;
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
//            $this->sender([$user->mobile],[$message]);

            //
            $user->update([
                'loginCode'=>$code,
                'loginCodeExpire'=>Carbon::now()->addSeconds($this->loginCodeLifeSecond)
            ]);

            return $this->baseJsonResponse(['status'=>true],[
                'title'=>'کد ورود به شماره موبایل ارسال شد',
                'description'=>"کد تا $this->loginCodeLifeSecond  ثانیه معتبر میباشد",
                'message'=>$message,
            ]);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[
                $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

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
                $smsTariff = $this->getSmsTariff();
                $smsCountForNewUser = $this->getSafe('newUserSmsCount');
                if ($smsCountForNewUser && $smsCountForNewUser > 0){
                    $user->update([
                       'register_completed'=>true,
                       'account_balance' => $user->account_balance + ($smsCountForNewUser * $smsTariff)
                    ]);
                }
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
                Response::HTTP_BAD_REQUEST);

        }

    }

    public function getMyDetails(Request $request){
        try {
            $user = $request->user();
            $smsTariff = $this->getSmsTariff();
            return $this->baseJsonResponse([
                'user'=>  new UserResource($user,(int)$smsTariff)
            ],['title'=>'مشخصات کاربر'],Response::HTTP_OK);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function setMyDetails(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'nullable',
                'email' => 'nullable',
                'title' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->baseJsonResponse(['status'=>false],[
                    'validator_errors'=>$validator->messages()
                ]);
            }

            $user = $request->user();
            $update=$user->update([
                'name'=>$request->name,
                'account_title'=>$request->title,
                'email'=>$request->email
            ]);
            if ($update){
                return $this->baseJsonResponse([
                    'status'=>  true
                ],['title'=>'مشخصات با موفقیت ثبت شد']);
            }else{
                return $this->baseJsonResponse([
                    'status'=>  false
                ],['title'=>'مشکلی در ویرایش مشخصات بوجود آمد']);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>  false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function getMySocials(Request $request){
        try {
            $user = $request->user();
            $medias = Media::query()->where('status',true)->get();

            return $this->baseJsonResponse([
                'status'=>true,
                'medias'=>  new MediaCollection($medias,$user)
            ],['title'=>'لیست لینک ها به همراه مقادیر ثبت شده توسط کاربر']);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>  false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function setMySocials(Request $request){
        try {
            $user = $request->user();
            $res = $this->setUserLink($request->values,$user);
            if ($res){
            return $this->baseJsonResponse(['status'=>  true],['title'=>'لینک ها ثبت شد']);
            }else{
                return $this->baseJsonResponse(['status'=>  false],['title'=>'مشکلی در ثبت لینک ها بوجود آمد']);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    public function getPackages(){
        try {
            $packages = Package::query()->where('status',true)->get();
            $smsTariff = $this->getSmsTariff();
            return $this->baseJsonResponse([
                'status'=>  true,
                'packages'=>new PackageCollection($packages,$smsTariff)
            ],['title'=>'لیست پک های پیامکی']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getPackage(Package $package){
        try {
            if ($package->status){
                $count = $package->count;
                $prices = $this->packPayPriceCalculator($count);
                return $this->baseJsonResponse([
                    'status'=>  true,
                    'packPrice'=>$prices["mainPrice"],
                    'commissionPercentage'=>$prices["commissionPercentage"],
                    'commissionPrice'=>$prices["commissionPrice"],
                    'payPrice'=>$prices["totalPrice"],
                ],['title'=>'مشخصات و قیمت پک پیامکی']);
            }else{
                return $this->baseJsonResponse([
                    'status'=>  false,
                ],['title'=>'پکیج مورد نظر یافت نشد']);
            }


        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSentBox(Request $request){
        try {
            $user = $request->user();
            $user_sent_box = $user->user_sends()->latest()->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'sent_box'=>new SentBoxCollection($user_sent_box)
            ],['title'=>'لیست آخرین ارسال ها']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
}
