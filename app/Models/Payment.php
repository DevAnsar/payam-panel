<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'price',
        'package_id',
        'authority',
        'ref_id',
        'status',
        'body',
        'mobile',
        'email',
        'price_type'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    /**
     * @param $query
     * @param $month
     * @param $payment_type <"Paid"|"Canceled">
     * @return mixed
     */
    public function scopeSpanningPayments($query,$month,$payment_type){
        return $query->selectRaw('MONTH(created_at) monthTH, count(*) published , sum(price) cost')
            ->where('created_at','>',Carbon::now()->subMonths($month))
            ->whereStatus($payment_type)//Paid , Canceled
            ->groupBy('monthTH')
            ->latest();
//        return  $query->select(DB::raw('COUNT(*) as count'),DB::raw("date_part('month',created_at) as month"))
//            ->whereYear('created_at', date('Y'))
//            ->groupBy(DB::raw("date_part('month', created_at) "))
//            ->latest();


    }
}
