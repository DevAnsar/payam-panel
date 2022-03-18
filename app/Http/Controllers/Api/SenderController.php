<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SenderController extends Controller
{

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['اطلاعات ورودی صحیح نمیباشد'],
            ]);
        }
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function send(Request $request){

        return response()->json(['users'=>User::all()]);
    }

    public function sendToMobile(Request $request){
        $mobile = $request->mobile;
        $result = $this->sendSmsFromKaveNegar($mobile);
        return response()->json([
            'status'=>true,
            'res'=>$result
        ]);
    }
}
