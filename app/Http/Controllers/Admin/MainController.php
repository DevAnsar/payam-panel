<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function startPrj(){

        $userData=[
            'name'=>'ansar mirzayi',
            'email'=>'ansarmirzayi@gmail.com',
            'password'=>Hash::make('12345678'),
            'mobile'=>"09036587580",

        ];
        $has_user=User::query()->where('email',$userData['email'])->first();
        if (! $has_user)
        User::create($userData);

//        Media::create([
//            'title'=>'اینستاگرام',
//            'icon' =>'/medias/instagram.png',
//            'base_url'=>'https://instagram.com/',
//            'status'=>true
//        ]);
//        Media::create([
//            'title'=>'تلگرام',
//            'icon' =>'/medias/telegram.png',
//            'base_url'=>'https://t.me/',
//            'status'=>true
//        ]);
//        Media::create([
//            'title'=>'آنلاین شاپ',
//            'icon' =>'/medias/shop.png',
//            'base_url'=>'',
//            'status'=>true
//        ]);

        return redirect(route('login'));
    }


    public function dashboard(){
        return view('admin.dashboard');
    }
}
