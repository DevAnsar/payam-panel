<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $protocol ='KAVE_NEGAR';

    /**
     * @param array $mobiles
     * @param string $message
     * @return array
     */
    public function sendSmsFromKaveNegar($mobiles,$message){
        $api = new \Kavenegar\KavenegarApi( env('KAVE_NEGAR_API_KEY') );
//        $sender = "10004346";
        $sender = "10008663";
//        $message = "";

        $result = $api->Send($sender,$mobiles,$message);
//        if($result){
//            foreach($result as $r){
//                echo "messageid = $r->messageid";
//                echo "message = $r->message";
//                echo "status = $r->status";
//                echo "statustext = $r->statustext";
//                echo "sender = $r->sender";
//                echo "receptor = $r->receptor";
//                echo "date = $r->date";
//                echo "cost = $r->cost";
//            }
//        }
        return $result;
    }


    /**
     * @param array $mobiles
     * @param string $message
     * @return array
     */
    public function sender($mobiles , $message){

        if($this->protocol == 'KAVE_NEGAR')
        return $this->sendSmsFromKaveNegar($mobiles,$message);
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
