<?php

namespace App\Http\Controllers;

use App\lib\SMSIR\SmsIRClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $protocol ='SMSIR';




    /**
     * @param array $mobiles
     * @param string $message
     * @return array
     */
    public function sender($mobiles , $message){

        try{

            if($this->protocol == 'KAVE_NEGAR'){
                $sender=new KaveNegarController();
                return $sender->sendSmsFromKaveNegar($mobiles,$message);
            }elseif($this->protocol == 'SMSIR'){

                $apiKey = getenv('API_KEY');
                $secretKey = getenv('SECRET_KEY');
                $lineNumber = getenv('LINE_NUMBER');

                $smsir = new SmsIRClient($apiKey, $secretKey, $lineNumber);
                return $res = $smsir->send([$message], $mobiles);
            }

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
}
