<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSmsFromKaveNegar($mobile){
        $api = new \Kavenegar\KavenegarApi( env('KAVE_NEGAR_API_KEY') );
//        $sender = "10004346";
        $sender = "10008663";
        $message = "آدرس اینستاگرام من : dev_ansar";
        $receptor = array($mobile);
        $result = $api->Send($sender,$receptor,$message);
        if($result){
            foreach($result as $r){
                echo "messageid = $r->messageid";
                echo "message = $r->message";
                echo "status = $r->status";
                echo "statustext = $r->statustext";
                echo "sender = $r->sender";
                echo "receptor = $r->receptor";
                echo "date = $r->date";
                echo "cost = $r->cost";
            }
        }
        return $result;
    }
}
