<?php

namespace App\lib;

use App\Models\Safe;
use Illuminate\Http\Request;


trait FileUploader
{

    public function saveFile($file,$path){
        $file_address = null;
        $image_name = $file->getClientOriginalName();
        $file->storeAs("public/".$path,$image_name);
        $file_address = $path ."/". $image_name;
        return $file_address;
    }
}