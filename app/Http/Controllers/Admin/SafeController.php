<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\lib\SMSIR\SmsIRClient;
use App\Models\Safe;
use Illuminate\Http\Request;

class SafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index()
    {
        $safes = Safe::all();

        $apiKey = env('SMSIR_API_KEY');
        $secretKey = env('SMSIR_SECRET_KEY');
        $lineNumber = env('SMSIR_LINE_NUMBER');

        $smsClient = new SmsIRClient($apiKey,$secretKey,$lineNumber);
        $smsCredit = $smsClient->smsCredit()['credit'];

        return view('admin.safes.index',compact('safes','smsCredit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.safes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
            'description' => 'nullable'
        ]);
        try {
            Safe::create([
                'key'=>$request->input('key'),
                'value'=>$request->input('value'),
                'description'=>$request->input('description')
            ]);

            return redirect(route('admin.safes.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Safe  $safe
     * @return \Illuminate\Http\Response
     */
    public function show(Safe $safe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Safe  $safe
     * @return \Illuminate\Http\Response
     */
    public function edit(Safe $safe)
    {
        return view('admin.safes.edit',compact('safe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Safe  $safe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Safe $safe)
    {
        $request->validate([
            'value' => 'required',
            'description' => 'nullable'
        ]);
        try {
            $safe->update([
                'value' => $request->input('value'),
                'description' => $request->input('description'),
            ]);

            return redirect(route('admin.safes.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Safe  $safe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Safe $safe)
    {
        //
    }
}
