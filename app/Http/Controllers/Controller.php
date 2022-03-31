<?php

namespace App\Http\Controllers;

use App\lib\SafeSettings;
use App\lib\SMSIR\SmsIRClient;
use App\lib\Zarinpal\Zarinpal;
use App\Models\Media;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,SafeSettings;
    private $protocol ='SMSIR';

    /**
     * @param  array  $mobiles
     * @param $messages
     * @return array
     */
    public function sender($mobiles , $messages){

        try{

            if($this->protocol == 'KAVE_NEGAR'){
                $sender=new KaveNegarController();
                $res = $sender->sendSmsFromKaveNegar($mobiles,$messages[0]);
                return [
                    'isSuccessful'=>$res['isSuccessful']
                ];
            }elseif($this->protocol == 'SMSIR'){
                $apiKey = env('SMSIR_API_KEY');
                $secretKey = env('SMSIR_SECRET_KEY');
                $lineNumber = env('SMSIR_LINE_NUMBER');
                $smsir = new SmsIRClient($apiKey, $secretKey, $lineNumber);
                $res = $smsir->send($messages, $mobiles);

                return [
                  'isSuccessful'=>$res['isSuccessful'],
                    'data'=>$res
                ];
            }

        }catch (\GuzzleHttp\Exception\GuzzleException $e) {
            error_log($e->getMessage(), 0);
        }
    }

    /**
     * @param  string  $message
     * @return string
     */
    public function addAdToMessage($message){

        try{
            $watermark="https://payamaksazi.ir";
            return $message."\n\n".$watermark;

        }catch (\GuzzleHttp\Exception\GuzzleException $e) {
            error_log($e->getMessage(), 0);
        }
    }

    /**
     * @param integer $length
     * @return string
     */
    public function generateRandomNumber($length = 8)
    {
        $random = "";
        srand((double)microtime() * 1000000);
        $data = "102345601234567899876543210890";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    /**
     * @param  User  $user
     * @return array
     */
    public function getMediasWithUserData(User $user){
        $titleSum = 0;
        $valueSum = 0;
        $medias = Media::query()->where('status',true)->get();
        foreach ($medias as $media){
            $media->link = $media->links()->where('user_id',$user->id)->first();
            $titleSum += (strlen($media->title) + strlen($media->base_url) + 1);
            if ($media->link)
                $valueSum += strlen($media->link->value);

        }
        return ['medias'=>$medias,'valueSum'=>$valueSum,'titleSum'=>$titleSum];
    }

    /**
     * @param  $medias
     * @return string
     */
    public function createLinksMessageWithUserMedias($medias){
        $message='';
        foreach ($medias as $media){
            if ($media->link){
                if (strlen($media->link->value) > 0)
                    $message = $message . $media->base_url.$media->link->value." :".$media->title." \n ";
            }
        }
        return $message;
    }

    /**
     * @param  array  $data
     * @param  array  $messages  ,
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function baseJsonResponse(array $data,array $messages,$status = Response::HTTP_OK){
        return response()->json(array_merge($data,['messages'=>$messages]),$status);
    }


    /**
     * @param  array  $values
     * @param  User  $user
     * @return bool
     */
    public function setUserLink($values,User $user){
        try {
            foreach ($values as $media_id => $value){
                if(Media::query()->find($media_id)){
                    $link = $user->links()->where('media_id',$media_id)->first();

                    if($link){
                        if ($value != null){
                            $link->update(['value'=>$value]);
                        }else{
                            $link->delete();
                        }

                    }else{
                        if ($value != null){
                            $user->links()->create([
                                'value'=>$value,
                                'media_id'=>$media_id
                            ]);
                        }
                    }
                }
            }
            return true;
        }catch (\Exception $exception){
            return false;
        }

    }

    /**
     * @param  string  $message
     * @return integer
     */
    public function getMessageContentCount($message){
        $message_length = strlen($message);
        if ($message_length > 0){
            if ($message_length - 70 <= 0){
                return 1;
            }else{
                $message_length -= 70;
                if ($message_length - 64 <= 0){
                    return 2;
                }else{
                    $message_length -= 64;
                    return ceil($message_length / 67) + 2;
                }
            }
        }

        return 0;
    }


    /**
     * @param $price
     * @param $callback
     * @param  string  $description
     * @param  string  $email
     * @param  string  $mobile
     * @param  bool  $SandBox
     * @param  bool  $ZarinGate
     */
    public function getPay($price,$callback,$description="تراکنش زرین پال",$email="",$mobile="",$SandBox = false,$ZarinGate =false){

        $MerchantID 	= env('ZP_MerchantID');
        $Amount 		= $price;
        $Description 	= $description;
        $Email 			= $email;
        $Mobile 		= $mobile;
        $CallbackURL 	= $callback;

        $zp 	= new Zarinpal($MerchantID);
        $result = $zp->request($Amount, $Description, $Email, $Mobile, $CallbackURL, $SandBox, $ZarinGate);

        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            // Success and redirect to pay
            $zp->redirect($result["StartPay"]);
        } else {
            // error
//            return $result;
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : ". $result["Status"];
            echo "<br />تفسیر و علت خطا : ". $result["Message"];
        }

    }

    /**
     * @throws \SoapFault
     */
    public function getVerify($price , $au ,$SandBox = true ,$ZarinGate = false){

        $MerchantID 	= env('ZP_MerchantID');
        $Amount 		= $price;

        $zp 	= new Zarinpal($MerchantID);
        $result = $zp->verify($Amount ,$au, $SandBox, $ZarinGate);

        return [
            'status'=>isset($result["Status"]) ? $result["Status"] : -1,
            'ref_id'=>$result["RefID"],
            'authority'=>$result["Authority"],
            'amount'=>$result["Amount"],
            'message'=>$result["Message"]
        ];
    }

    public function getBuyPackage(Package $package,Request $request){
        $user = $request->user();
        $price = $this->payPriceCalculator($package->count,'T');
        $payment = $user->payments()->create([
            'price' => $price,
            'price_type' => "T",
            'package_id'=>$package->id,
            'mobile'=>$user->mobile,
            'email'=> $user->email
        ]);

        if ($payment){
            return $this->getPay(
                $price,
                route('zp.buy_package.verify',['payment'=>$payment->id]),
                "خرید ".$package->title ,
                $user->email||"",
                $user->mobile||"",
                true
            );
        }else{
            echo 'payment err';
        }
    }

    public function getVerifyBuyPackage(Payment $payment , Request $request){
        $au = ($request->has("Authority") && $request->input("Authority") != "") ? $request->input("Authority") :"";
        $payment->update([
            'authority' => $au
        ]);
        $res = $this->getVerify(
            $payment->price,
            $au,
            true
        );

        $user = $payment->user;
        $price_calculated = $this->purePriceCalculator($res['amount'],$payment->price_type,"R");
        if ( $res["status"] == 100)
        {

            //1- update payment
            $payment->update([
                'ref_id'=> $res['ref_id'],
                'status'=> 'Paid'
            ]);

            //2- add package to user packages
            $user->user_packages()->create([
                'package_id'=> $payment->package_id,
                'price'=> $price_calculated['user_price'],
                'count'=> $payment->package->count,
                'description'=>$payment->package->title,
            ]);

            //3- update user account balance
            $user->update([
                'account_balance' => $user->account_balance + $price_calculated['user_price']
            ]);

            //4- deposit commission to site account
            $user_transaction = Transaction::create([
                'type' => 'deposit',
                'key' => 'monyInventory',
                'value' => $price_calculated['user_price'],
                'body' => 'خرید'.$payment->package->title,
                'account_balance' => "0",
            ]);

            $user_buy_set_safe = $this->setSafe($user_transaction->type,$user_transaction->key,$user_transaction->value);
            if ($user_buy_set_safe){
                $user_transaction->update([
                    'account_balance' => (string)$user_buy_set_safe,
                ]);
            }

            $site_transaction = Transaction::create([
                'type' => 'deposit',
                'key' => 'commissionInventory',
                'value' => $price_calculated['site_price'],
                'body' => 'کمسیون از خرید '.$payment->package->title,
                'account_balance' => "0",
            ]);

            $site_commission_buy_set_safe = $this->setSafe($site_transaction->type,$site_transaction->key,$site_transaction->value);
            if ($site_commission_buy_set_safe){
                $site_transaction->update([
                    'account_balance' => (string)$site_commission_buy_set_safe,
                ]);
            }



            // Success
            echo "تراکنش با موفقیت انجام شد";
            echo "<br />مبلغ : ". $res["amount"];
            echo "<br />کد پیگیری : ". $res["ref_id"];
            echo "<br />Authority : ". $res["authority"];
        } else {

            //1- update payment
            $payment->update([
                'status'=> 'Canceled',
                'body' => $res["message"]
            ]);

            // error
            echo "پرداخت ناموفق";
            echo "<br />کد خطا : ". $res["status"];
            echo "<br />تفسیر و علت خطا : ". $res["message"];
        }
    }

    public function payPriceCalculator($count,$return_price_type="R"){
        $smsTariff=$this->getSmsTariff();
        $commission = $this->getBuyCommissionPercentage(); //Percentage
        $price = $smsTariff * $count;

        // add commission to price
        $price = $price * (1 + $commission /100);

        if ($return_price_type == "T"){
            $price = $price / 10;
        }

        return $price;
    }

    public function purePriceCalculator($price,$input_price_type="R",$return_price_type="R"){
        if($input_price_type == "T"){
            $price = $price * 10;
        }
        //
        $commission = $this->getBuyCommissionPercentage(); //Percentage
        $userPrice = $price / (1 + $commission /100);
        $sitePrice = $price - $userPrice;
        return [
            'user_price'=> $return_price_type=="R" ? $userPrice : $userPrice/10,
            'site_price'=> $return_price_type=="R" ? $sitePrice : $sitePrice/10
        ];
    }
}
