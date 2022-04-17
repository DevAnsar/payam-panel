<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\lib\SMSIR\SmsIRClient;
use App\Models\Media;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Safe;
use App\Models\SentBox;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Artisan;
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

    public function storageLink(){
        $exitCode = Artisan::call('storage:link', [] );
        echo $exitCode; // 0 exit code for no errors.
    }

    public function showBankCallBackPage(){
        return view('web.bankCallBackPage');
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

        $amountInventory = number_format(Safe::query()->where("key","=","moneyInventory")->first()->value);
        $commissionInventory=number_format(Safe::query()->where("key","=","commissionInventory")->first()->value);

        $apiKey = env('SMSIR_API_KEY');
        $secretKey = env('SMSIR_SECRET_KEY');
        $lineNumber = env('SMSIR_LINE_NUMBER');
        $smsClient = new SmsIRClient($apiKey,$secretKey,$lineNumber);
        $smsCredit = number_format($smsClient->smsCredit()['credit']);

        // charts settings
        $year = "1401";

        $successPaymentsChartData=$this->paymentsChartData($year,'Paid');
        $canceledPaymentsChartData=$this->paymentsChartData($year,'Canceled');
        $paymentsPriceChartData = [
            'title' => "مجموع پرداخت ها در سال $year",
            'labels'=>$successPaymentsChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('پرداخت های موفق',$successPaymentsChartData['prices']),
                $this->lineChartDataItemCreator('پرداخت های ناموفق',$canceledPaymentsChartData['prices'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];
        $paymentsCountChartData = [
            'title' => "تعداد پرداخت ها در سال $year",
            'labels'=>$successPaymentsChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('پرداخت های موفق',$successPaymentsChartData['counts']),
                $this->lineChartDataItemCreator('پرداخت های ناموفق',$canceledPaymentsChartData['counts'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];

        $depositMoneyChartData=$this->transactionChartData("moneyInventory","deposit",$year);
        $harvestMoneyChartData=$this->transactionChartData("moneyInventory","harvest",$year);
        $moneyTransactionsChartData = [
            'title' => "گزارشات گاوصندوق - واریز و برداشت از حساب",
            'labels'=>$depositMoneyChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('تراکنشات واریز',$depositMoneyChartData['prices']),
                $this->lineChartDataItemCreator('تراکنشات برداشت',$harvestMoneyChartData['prices'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];
        $moneyTransactionsCountChartData = [
            'title' => "گزارشات گاوصندوق - تعداد واریز و برداشت از حساب",
            'labels'=>$depositMoneyChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('تعداد واریز',$depositMoneyChartData['counts']),
                $this->lineChartDataItemCreator('تعداد برداشت',$harvestMoneyChartData['counts'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];


        $depositCommissionChartData=$this->transactionChartData("commissionInventory","deposit",$year);
        $harvestCommissionChartData=$this->transactionChartData("commissionInventory","harvest",$year);
        $commissionTransactionsChartData = [
            'title' => "گزارشات گاوصندوق - واریز و برداشت کمسیون ها",
            'labels'=>$depositCommissionChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('کمسیون واریز',$depositCommissionChartData['prices']),
                $this->lineChartDataItemCreator('کمسیون برداشت',$harvestCommissionChartData['prices'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];
        $commissionTransactionsCountChartData = [
            'title' => "گزارشات گاوصندوق - تعداد واریز و برداشت از کمسیون",
            'labels'=>$depositMoneyChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('تعداد واریز',$depositCommissionChartData['counts']),
                $this->lineChartDataItemCreator('تعداد برداشت',$harvestCommissionChartData['counts'],'rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)')
            ],
        ];

        $usersChartData=$this->usersChartData($year);
        $usersCountChartData = [
            'title' => "گزارشات کاربران جدید به تفکیک ماه در سال $year",
            'labels'=>$usersChartData['labels'],
            'data'=>[
                $this->lineChartDataItemCreator('کاربران جدید',$usersChartData['counts'])
                ],
        ];




//        return $moneyChartData;
        return view('admin.dashboard',compact(
            'allUsersCount',
            'lastNewUsersCount',
            'allSendBoxCount',
            'lastSentDoxCount',
            'amountInventory',
            'commissionInventory',
            'smsCredit',
            'usersCountChartData',
            'paymentsPriceChartData',
            'paymentsCountChartData',
            'moneyTransactionsChartData',
            'moneyTransactionsCountChartData',
            'commissionTransactionsChartData',
            'commissionTransactionsCountChartData'
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

    public function transactionChartData($key = "moneyInventory",$type="Deposit",$year='1401'){
        $labels = [];
        $prices = [];
        $counts = [];
        for($i=12; $i >= 1; $i--){
            $monthDaysRange = $this->monthDaysRange($year,$i);
            $persian_date = $monthDaysRange['month_name'];
            $query = Transaction::query()
                ->whereDate('created_at', '>=', $monthDaysRange['first_month'])
                ->whereDate('created_at', '<=', $monthDaysRange['end_month'])
                ->where('Key','=',$key)
                ->whereType($type);

            $labels[]=$persian_date;
            $prices[]=$query->sum('value');
            $counts[]=$query->get()->count();
        }
        return [
            'labels'=>array_reverse($labels),
            'prices'=>array_reverse($prices),
            'counts'=>array_reverse($counts)
        ];
    }

    public function usersChartData($year='1401'){
        $labels = [];
        $counts = [];
        for($i=12; $i >= 1; $i--){
            $monthDaysRange = $this->monthDaysRange($year,$i);
            $persian_date = $monthDaysRange['month_name'];
            $query = User::query()
                ->whereDate('created_at', '>=', $monthDaysRange['first_month'])
                ->whereDate('created_at', '<=', $monthDaysRange['end_month']);

            $labels[]=$persian_date;
            $counts[]=$query->get()->count();
        }
        return [
            'labels'=>array_reverse($labels),
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

    /**
     * @param  string  $label
     * @param  array  $data
     * @param  string  $backgroundColor
     * @param  string  $borderColor
     * @param  int  $borderWidth
     * @return array
     */
    private function lineChartDataItemCreator(
        string $label,
        array $data,
        string $backgroundColor = 'rgba(54, 162, 235, 0.2)',
        string $borderColor = 'rgba(54, 162, 235, 1)',
        int $borderWidth=1
    ){
        return [
            'label'=>$label,
            'data' =>$data,
            'backgroundColor'=>$backgroundColor,
            'borderColor' =>$borderColor,
            'borderWidth'=>$borderWidth
        ];
    }
}
