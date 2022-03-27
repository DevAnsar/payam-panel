<?php

namespace App\Http\Controllers;

use App\lib\SMSIR\SmsIRClient;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
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
    public function sender($mobiles , $messages){

        try{

            if($this->protocol == 'KAVE_NEGAR'){
                $sender=new KaveNegarController();
                return $sender->sendSmsFromKaveNegar($mobiles,$messages[0]);
            }elseif($this->protocol == 'SMSIR'){

                $apiKey = getenv('API_KEY');
                $secretKey = getenv('SECRET_KEY');
                $lineNumber = getenv('LINE_NUMBER');

                $smsir = new SmsIRClient($apiKey, $secretKey, $lineNumber);
                return $res = $smsir->send($messages, $mobiles);
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
}
