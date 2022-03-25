<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
        'user_id',
        'media_id',
    ];

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
