<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SenderController extends Controller
{

    public function sendSocialToMobile(Request $request){

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'messages'=>$validator->messages()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $mobile = $request->mobile;
            $user = $request->user();
            if($user){

                $mediasResponse = $this->getMediasWithUserData($user);
                $medias = $mediasResponse['medias'];

                $links = $this->createLinksMessageWithUserMedias($medias);
                $links = $this->addAdToMessage($links);
                $result = $this->sender([$mobile],[$links]);

                return response()->json([
                    'status'=>true,
                    'message'=>$links,
                    'message_len'=>strlen($links),
                    'res'=>$result,

                ],Response::HTTP_OK);
            }
            return response()->json([
                'status'=>false,
                'messages'=>[
                    'title'=>'کاربر یافت نشد'
                ]
            ],Response::HTTP_BAD_REQUEST);
        }catch (\Exception $exception){
            return response('','500')->json([
                'status'=>false,
                'messages'=>$exception->getMessage()
            ],Response::HTTP_BAD_REQUEST);
        }

    }
}
