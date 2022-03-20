<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function startPrj(){

        $userData=[
            'name'=>'ansar mirzayi',
            'email'=>'ansarmirzayi@gmail.com',
            'password'=>Hash::make('12345678')
        ];
        $has_user=User::query()->where('email',$userData['email'])->first();
        if (! $has_user)
        User::create($userData);



        return redirect(route('login'));
    }


    public function dashboard(){
        return view('admin.dashboard');
    }
}
