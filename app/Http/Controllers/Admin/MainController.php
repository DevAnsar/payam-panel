<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\lib\SMSIR\SmsIRClient;
use App\Models\Media;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Safe;
use App\Models\SentBox;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
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

        Media::create([
            'title'=>'اینستاگرام',
            'icon' =>'/medias/instagram.png',
            'base_url'=>'https://instagram.com/',
            'status'=>true
        ]);
        Media::create([
            'title'=>'تلگرام',
            'icon' =>'/medias/telegram.png',
            'base_url'=>'https://t.me/',
            'status'=>true
        ]);
        Media::create([
            'title'=>'آنلاین شاپ',
            'icon' =>'/medias/shop.png',
            'base_url'=>'',
            'status'=>true
        ]);

        Package::create([
            'title'=>'پنل 20 عددی',
            'price'=>'5000',
            'count'=>20,
            'icon'=>'',
            'status'=>true
        ]);

        Package::create([
            'title'=>'پنل 50 عددی',
            'price'=>'15000',
            'count'=>50,
            'icon'=>'',
            'status'=>true
        ]);

        return redirect(route('login'));
    }


    public function dashboard(){

        $allUsersCount = number_format(User::query()->count());
        $lastNewUsersCount = number_format(User::query()
            ->where("created_at",">=",Carbon::now()->subMonth())
            ->get()->count());

        $sendBoxQuery=SentBox::query();
        $allSendBoxCount =number_format($sendBoxQuery->count());
        $lastSentDoxCount = number_format($sendBoxQuery->where("created_at",">=",Carbon::now()->subMonth())
            ->get()->count());

        $amountInventory = number_format(Safe::query()->where("key","=","monyInventory")->first()->value);
        $commissionInventory=number_format(Safe::query()->where("key","=","commissionInventory")->first()->value);

        $apiKey = env('SMSIR_API_KEY');
        $secretKey = env('SMSIR_SECRET_KEY');
        $lineNumber = env('SMSIR_LINE_NUMBER');
        $smsClient = new SmsIRClient($apiKey,$secretKey,$lineNumber);
        $smsCredit = number_format($smsClient->smsCredit()['credit']);

        // charts settings
        $successPaymentsChartData=$this->paymentsChartData('1401','Paid');
        $canceledPaymentsChartData=$this->paymentsChartData('1401','Canceled');
        $paymentsChartData = [
            'labels'=>$successPaymentsChartData['labels'],
            'paid_count'=>$successPaymentsChartData['counts'],
            'paid_price'=>$successPaymentsChartData['prices'],
            'canceled_count'=>$canceledPaymentsChartData['counts'],
            'canceled_price'=>$canceledPaymentsChartData['prices'],
        ];


        return view('admin.dashboard',compact(
            'allUsersCount',
            'lastNewUsersCount',
            'allSendBoxCount',
            'lastSentDoxCount',
            'amountInventory',
            'commissionInventory',
            'smsCredit',
            'paymentsChartData'
        ));
    }

    public function paymentsChartData($year='1401',$pay_type="Paid"){
        $labels = [];
        $prices = [];
        $counts = [];
        for($i=12; $i >= 1; $i--){
            $monthDaysRange = $this->monthDaysRange($year,$i);
            $persian_date = $monthDaysRange['month_name'];
            $query = Payment::query()
                ->whereDate('created_at', '>=', $monthDaysRange['first_month'])
                ->whereDate('created_at', '<=', $monthDaysRange['end_month'])
                ->whereStatus($pay_type);

            $labels[]=$persian_date;
            $prices[]=$query->sum('price');
            $counts[]=$query->get()->count();
        }
        return [
            'labels'=>array_reverse($labels),
            'prices'=>array_reverse($prices),
            'counts'=>array_reverse($counts)
        ];
    }

    private function monthDaysRange($year,$month){

        $day = 1;
        $date = Verta::createJalali($year, $month, $day);
        $month_day_count = $date->daysInMonth;
        $month_name = $date->format('%B');

        $first_month_jalali=Verta::getGregorian($year, $month, $day);
        $first_month =Carbon::create($first_month_jalali[0],$first_month_jalali[1],$first_month_jalali[2]);
        $end_month_jalali=Verta::getGregorian($year, $month, $month_day_count);
        $end_month =Carbon::create($end_month_jalali[0],$end_month_jalali[1],$end_month_jalali[2]) ;

        return [
            'first_month'=>$first_month,
            'end_month'=>$end_month,
            'month_name'=>$month_name
        ];
    }
}
