<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'account_title',
        'user_type',
        'email',
        'password',
        'account_balance',
        'usedCount',
        'mobile',
        'loginCode',
        'loginCodeExpire',
        'addMobileToCustomers',
        'register_completed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_type',
        'account_balance'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_customers(){
        return $this->hasMany(Customer::class);
    }

    public function user_packages(){
        return $this->hasMany(UserPackage::class);
    }

    public function user_sends(){
        return $this->hasMany(SentBox::class);
    }

    public function links(){
        return $this->hasMany(Links::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
