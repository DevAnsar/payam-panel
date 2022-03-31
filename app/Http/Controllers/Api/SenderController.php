<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\lib\SafeSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SenderController extends Controller
{
    use SafeSettings;
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
                $smsTariff = $this->getSmsTariff();
                $contentCount = $this->getMessageContentCount($links);

                return $smsTariff * $contentCount * 2.2;
//                $result = $this->sender([$mobile],[$links]);
//                if ($result['isSuccessful']){
//
//                    return $this->baseJsonResponse([
//                        'status'=>true,
//                        'message'=>$links,
//                        'message_len'=>strlen($links),
//                        'data'=>$result['data']
//                    ],['لینک ها با موفقیت ارسال شد'],Response::HTTP_OK);
//
//
//                }else{
//                    return $this->baseJsonResponse(['status'=>false],['مشکلی از طرف سرویس دهنده به وجود آمد'],Response::HTTP_BAD_REQUEST);
//                }

            }else{
                return $this->baseJsonResponse(['status'=>false],['کاربر یافت نشد'],Response::HTTP_BAD_REQUEST);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
