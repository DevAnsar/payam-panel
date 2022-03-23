<?php

namespace App\Http\Controllers;

class KaveNegarController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

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
}
