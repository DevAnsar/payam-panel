<?php

namespace App\lib;

use App\Models\Media;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Safe;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait Cleaner
{
    public function startPrj(Request $request){
        $user = $request->user();
        if ($user->mobile == "09306029572") {
            $userData = [
                'name' => 'ansar mirzayi',
                'email' => 'ansarmirzayi@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => "09036587580",

            ];
            $has_user = User::query()->where('email', $userData['email'])->first();
            if (!$has_user) {
                User::create($userData);

                Media::create([
                    'title' => 'اینستاگرام',
                    'icon' => '/medias/instagram.png',
                    'base_url' => 'https://instagram.com/',
                    'status' => true
                ]);
                Media::create([
                    'title' => 'تلگرام',
                    'icon' => '/medias/telegram.png',
                    'base_url' => 'https://t.me/',
                    'status' => true
                ]);
                Media::create([
                    'title' => 'آنلاین شاپ',
                    'icon' => '/medias/shop.png',
                    'base_url' => '',
                    'status' => true
                ]);

                Package::create([
                    'title' => 'پنل 20 عددی',
                    'price' => '5000',
                    'count' => 20,
                    'icon' => '',
                    'status' => true
                ]);

                Package::create([
                    'title' => 'پنل 50 عددی',
                    'price' => '15000',
                    'count' => 50,
                    'icon' => '',
                    'status' => true
                ]);

            }
        }
        return redirect(route('login'));
    }

    public function storageLink(){
        $exitCode = Artisan::call('storage:link');
        echo $exitCode; // 0 exit code for no errors.
    }

    public function hardReset(Request $request){
        $user = $request->user();
        if ($user->mobile == "09306029572"){
            DB::statement("SET foreign_key_checks=0");
            Payment::truncate();
            Transaction::truncate();
            DB::statement("SET foreign_key_checks=1");
            $moneyInventory = Safe::query()->where("key","moneyInventory")->first();
            $moneyInventory?->update([
                "value" => "0"
            ]);
            $commissionInventory = Safe::query()->where("key","commissionInventory")->first();
            $commissionInventory?->update([
                "value"=>"0"
            ]);
        }
        return redirect(route("admin.safes.index"));
    }
}
