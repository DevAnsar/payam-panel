<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\lib\SafeSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SenderController extends Controller
{
    use SafeSettings;
    public function sendSocialToMobile(Request $request){

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

                $mediasResponse = $this->getMediasWithUserData($user);
                $medias = $mediasResponse['medias'];

                $links = $this->createLinksMessageWithUserMedias($medias);
                $message = $user->name ."\n".$links;
                $message = $this->addAdToMessage($message);
                $smsTariff = $this->getSmsTariff();
                $contentCount = $this->getMessageContentCount($message);

                //check user packages
                $user_sms_inventory = $user->user_packages()
                    ->where('expired_at','>=',Carbon::now())
                    ->where('inventory','>','0')
                    ->sum('inventory');

                if ($user_sms_inventory && $user_sms_inventory >= $contentCount){
                        $result = $this->sender([$mobile],[$message]);
                        if ($result['isSuccessful']){
                            // update user packages
                            $user_packages = $user->user_packages()
                                ->where('expired_at','>=',Carbon::now())
                                ->where('inventory','>','0')
                                ->orderBy('inventory','asc')
                                ->get();
                            $_content_count=$contentCount;
                            foreach ($user_packages as $user_package){
                                $pack_inventory = $user_package->inventory;
                                if ($_content_count > $pack_inventory){
                                    $user_package->update(['inventory'=>'0']);
                                    $_content_count = $_content_count - $pack_inventory;
                                }else{
                                    $user_package->update(['inventory'=>$pack_inventory - $_content_count]);
                                    continue;
                                }
                            }

                            // update user data
                            $user->update([
                                'usedCount' => $user->usedCount + $contentCount,
                                //'account_balance' => $user->account_balance - $price
                            ]);

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
                                'message_len'=>strlen($message),
                                'data'=>$result['data']
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
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
