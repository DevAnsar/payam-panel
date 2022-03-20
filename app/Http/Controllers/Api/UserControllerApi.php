<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserControllerApi extends Controller
{
    public function login_send_code(Request $request){

        $request->validate([
            'mobile' => 'required|size=11'
        ]);

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
            $this->sender([$user->mobile],$message);

            //
            $user->update([
                'loginCode'=>$code,
                'loginCodeExpire'=>Carbon::now()->addSeconds(60)
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'کد ورود به شماره موبایل ارسال شد'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>false,
                'message'=>$exception->getMessage()
            ]);
        }

    }

    public function login_with_mobile(Request $request){
        $request->validate([
            'mobile' => 'required|size:11',
            'code' => 'required|size:4',
            'device_name' => 'required',
        ]);
        $user = User::where('mobile', $request->mobile)->first();

        if (! $user ||  $request->code != $user->loginCode ) {
            throw ValidationException::withMessages([
                'mobile' => ['اطلاعات ورودی صحیح نمیباشد'],
            ]);
        }
        if ($user->loginCodeExpire < Carbon::now()){
            throw ValidationException::withMessages([
                'code' => ['کد وارد شده منقضی شده است'],
            ]);
        }
        return $user->createToken($request->device_name)->plainTextToken;
    }
}
