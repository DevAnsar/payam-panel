<?php

namespace App\lib;

use App\Models\Safe;
use Illuminate\Http\Request;


trait FileUploader
{

    public function saveFile($file,$path){
        $file_address = null;
//        if($request->hasFile($file_name)){
            $image = $file;
            $image_name = $image->getClientOriginalName();
            $file->storeAs("public/".$path,$image_name);
            $file_address = $path ."/". $image_name;
//        }
        return $file_address;
    }
}