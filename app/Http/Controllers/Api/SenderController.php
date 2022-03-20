<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SenderController extends Controller
{

    public function send(Request $request){
        return response()->json(['users'=>User::all()]);
    }

    public function sendSocialToMobile(Request $request){

        $request->validate(['mobile'=>'required|size:11']);
        try{
            $mobile = $request->mobile;
            $result = $this->sender([$mobile],"آدرس اینستاگرام من : dev_ansar");
            return response()->json([
                'status'=>true,
                'res'=>$result
            ]);
        }catch (\Exception $exception){
            return response('','500')->json([
                'status'=>false,
                'res'=>$exception->getMessage()
            ]);
        }

    }
}
