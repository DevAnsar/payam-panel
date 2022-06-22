<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\lib\SafeSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SenderController extends Controller
{
    use SafeSettings;

    /**
     * send authenticated user socials to customer
     * @param Request $request
     * @return JsonResponse
     */
    public function sendSocialToMobile(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11'
        ]);

        if ($validator->fails()) {
            return $this->baseJsonResponse(['status'=>false],['validator_errors'=>$validator->messages()]);
        }

        try{
            $mobile = $request->mobile;
            $user = $request->user();
            if($user){
                $message = $this->userSmsBuilder($user);
                $contentCount = $this->getMessageContentCount($message);
                //check user packages
                $user_sms_inventory = $this->userSmsInventory($user);

                if ($user_sms_inventory && $user_sms_inventory >= $contentCount){
                        $result = $this->sender([$mobile],[$message]);
                        if ($result['isSuccessful']){
                            // update user packages
                            $this->deductionFromTheUserAccount($user,$contentCount);

                            // log to user sends
                            $user->user_sends()->create([
                                'mobile'=>$mobile,
                                'text'=>$message
                            ]);

                            // add new phone to users customers
                            if ($user->addMobileToCustomers){
                                if (! $user->user_customers()->where('mobile',$mobile)->first()){
                                    $user->user_customers()->create([
                                        'mobile'=>$mobile
                                    ]);
                                }
                            }


                            return $this->baseJsonResponse([
                                'status'=>true,
                                'message'=>$message,
//                                'message_len'=>strlen($message),
//                                'data'=>$result['data']
                            ],['title'=>'لینک ها با موفقیت ارسال شد']);


                        }
                        else{
                            return $this->baseJsonResponse(['status'=>false],['title'=>'مشکلی از طرف سرویس دهنده به وجود آمد']);
                        }

                }else{
                    return $this->baseJsonResponse(['status'=>false],['title'=>'موجودی حساب برای ارسال پیامک کافی نمیباشد']);
                }

            }else{
                return $this->baseJsonResponse(['status'=>false],['title'=>'کاربر یافت نشد']);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
