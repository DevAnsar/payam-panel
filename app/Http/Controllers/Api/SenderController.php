<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    public function send(Request $request){

        return response()->json(['users'=>User::all()]);
    }
}
