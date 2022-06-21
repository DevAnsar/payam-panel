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
use Carbon\Carbon;
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
     * @param array $mobiles
     * @param array $messages
     * @return array|string|void
     */
    public function sender(array $mobiles , array $messages)
    {

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
           return $e->getMessage();
        }
    }

    /**
     * @param string $message
     * @return string
     */
    public function addAdToMessage(string $message): string
    {

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
    public function generateRandomNumber(int $length = 8): string
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
    public function createLinksMessageWithUserMedias($medias): string
    {
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
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function baseJsonResponse(array $data, array $messages, int $status = Response::HTTP_OK): \Illuminate\Http\JsonResponse
    {
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

    /** calculate message content
     * @param string $message
     * @return integer
     */
    public function getMessageContentCount(string $message): int
    {
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
     *  create final sms content fpr user
     * @param
     * @return string
     */
    public function userSmsBuilder($user): string
    {
        $mediasResponse = $this->getMediasWithUserData($user);
        $medias = $mediasResponse['medias'];
        $links = $this->createLinksMessageWithUserMedias($medias);
        $message = $user->name ."\n".$links;
        return $this->addAdToMessage($message);
    }
    /**
     * @param $price
     * @param $callback
     * @param string $description
     * @param string $email
     * @param string $mobile
     * @param bool $SandBox
     * @param bool $ZarinGate
     */
    public function getPay($price, $callback, string $description="تراکنش زرین پال", string $email="", string $mobile="", bool $SandBox = false, bool $ZarinGate =false){

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
     * @param string $price
     * @param $au
     * @param bool $SandBox
     * @param bool $ZarinGate
     * @return array
     * @throws
     */
    public function getVerify(string $price , $au , bool $SandBox = true , bool $ZarinGate = false): array
    {
        $MerchantID 	= env('ZP_MerchantID');
        $Amount 		= $price;

        $zp 	= new Zarinpal($MerchantID);
        $result = $zp->verify($Amount ,$au, $SandBox, $ZarinGate);

        return [
            'status'=> $result["Status"] ?? -1,
            'ref_id'=>$result["RefID"],
            'authority'=>$result["Authority"],
            'amount'=>$result["Amount"],
            'message'=>$result["Message"]
        ];
    }

    public function getBuyPackage(Package $package,Request $request){
//        $user = $request->user();
        $user = User::find(6);
        $prices = $this->packPayPrice((string)$package->price,'T');
        $payPrice = $prices["totalPrice"];
        $payment = $user->payments()->create([
            'price' => $payPrice,
            'price_type' => "T",
            'package_id'=>$package->id,
            'mobile'=>$user->mobile,
            'email'=> $user->email
        ]);

        if ($payment){
            $this->getPay(
                $payPrice,
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
        if ( $res["status"] == 100)
        {
            $price_calculated = $this->purePriceCalculator((string)$res['amount'],$payment->price_type,"R");
            //1- update payment
            $payment->update([
                'ref_id'=> $res['ref_id'],
                'status'=> 'Paid',
                'body'=> $payment->body . $res["message"]
            ]);

            //2- add package to user packages
            $package = $payment->package;
            $user->user_packages()->create([
                'package_id'=> $payment->package_id,
                'price'=> $price_calculated['user_price'],
                'count'=> $package->count,
                'inventory'=> $package->count,
                'started_at'=> Carbon::now(),
                'expired_at'=> Carbon::now()->addDays($package->days),
                'description'=>$package->title,
                'tariff'=>(string)((int) $package->price / (int) $package->count),
            ]);

            //3- update user account balance
//            $user->update([
//                'account_balance' => $user->account_balance + $price_calculated['user_price']
//            ]);

            //4- deposit commission to site account
            $user_buy_set_safe = $this->setSafe('deposit','moneyInventory',$price_calculated['user_price']);
            if ($user_buy_set_safe){
                Transaction::create([
                    'type' => 'deposit',
                    'key' => 'moneyInventory',
                    'value' => $price_calculated['user_price'],
                    'body' => 'خرید'.$payment->package->title,
                    'account_balance' => (string)$user_buy_set_safe,
                ]);
            }


            $site_commission_buy_set_safe = $this->setSafe('deposit','commissionInventory',$price_calculated['site_price']);
            if ($site_commission_buy_set_safe){
                Transaction::create([
                    'type' => 'deposit',
                    'key' => 'commissionInventory',
                    'value' => $price_calculated['site_price'],
                    'body' => 'کمسیون از خرید '.$payment->package->title,
                    'account_balance' => (string)$site_commission_buy_set_safe,
                ]);
            }
            // Success
            $message='پرداخت با موفقیت انجام شد';
            $type='success';
            return view('web.bankCallBackPage',compact('message','type'));

        } else {

            //1- update payment
            $payment->update([
                'status'=> 'Canceled',
                'body' => $res["message"]
            ]);

            // error
            $message='پرداخت ناموفق.' . $res["message"];
            $type='danger';
            return view('web.bankCallBackPage',compact('message','type'));
        }
    }

//    public function packPayPriceCalculator($count,$return_price_type="R"){
//        $smsTariff=$this->getSmsTariff();
//        $commission = $this->getBuyCommissionPercentage(); //Percentage
//        $main_price = $smsTariff * $count;
//
//        // add commission to price
//        $commission_price = $main_price * $commission /100;
//        $total_price = $main_price + $commission_price;
//
//        if ($return_price_type == "T"){
//            $total_price = $total_price / 10;
//            $commission_price = $commission_price / 10;
//            $main_price = $main_price / 10;
//        }
//
//        return [
//            "mainPrice"=>$main_price,
//            "commissionPercentage"=>$commission,
//            "commissionPrice"=>$commission_price,
//            "totalPrice"=>$total_price,
//        ];
//    }

    /**
     * @param string $price
     * @param string $return_price_type
     * @return array
     */
    public function packPayPrice(string $price, string $return_price_type="R"){

        $commission = $this->getBuyCommissionPercentage(); //Percentage

        // add commission to price
        $commission_price = (float)$price * $commission /100;
        $total_price = (float)$price + $commission_price;

        if ($return_price_type == "T"){
            $total_price = $total_price / 10;
            $commission_price = $commission_price / 10;
        }

        return [
            "commissionPercentage"=>(string)$commission,
            "commissionPrice"=>(string)$commission_price,
            "totalPrice"=>(string)$total_price,
        ];
    }

    /**
     * @param string $price
     * @param string $input_price_type
     * @param string $return_price_type
     * @return array
     */
    public function purePriceCalculator(string $price, string $input_price_type="R", string $return_price_type="R"){
        if($input_price_type == "T"){
            $price = (float)$price * 10;
        }
        //
        $commission = $this->getBuyCommissionPercentage(); //Percentage
        $userPrice = (float)$price / (1 + (float)$commission /100);
        $sitePrice = (float)$price - $userPrice;
        return [
            'user_price'=> $return_price_type=="R" ? $userPrice : $userPrice/10,
            'site_price'=> $return_price_type=="R" ? $sitePrice : $sitePrice/10
        ];
    }


    public function userSmsInventory(User $user){
        return $user->user_packages()
            ->where('expired_at','>=',Carbon::now())
            ->where('inventory','>','0')
            ->sum('inventory');
    }

    public function deductionFromTheUserAccount(User $user,$contentCount){
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
            }
        }
        // update user data
        $user->update([
            'usedCount' => $user->usedCount + $contentCount
        ]);
    }
}
