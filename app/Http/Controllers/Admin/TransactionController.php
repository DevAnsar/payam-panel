<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $transactionsQuery = Transaction::query();
        if($request->has('type')){
            $type = $request->input('type');
            if ($type == 'deposit' || $type == 'harvest'){
                $transactionsQuery = $transactionsQuery->where('type','=',$type);
            }
        }else{
            $type='all';
        }
        $transactions = $transactionsQuery->paginate(10);

        return view('admin.transactions.index',compact('transactions','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transactions.create');
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
            'type' => 'required',
            'price' => 'required',
            'count' => 'required',
            'body' => 'required|min:10',
        ]);
        try {

            $account_balance = 0;
            Transaction::create([
                'type' => $request->input('type'),
                'price' => $request->input('price'),
                'count' => $request->input('count'),
                'body' => $request->input('body'),
                'account_balance' => $account_balance,
            ]);

            return redirect(route('admin.transactions.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('admin.transactions.edit',compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
//            'count' => 'required',
            'body' => 'required|min:10',
        ]);

        $transaction->update([
//            'type' => $request->input('type'),
//            'price' => $request->input('price'),
//            'count' => $request->input('count'),
            'body' => $request->input('body'),
//            'account_balance' => $account_balance,
        ]);

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        // Decrease the total inventory

//        $transaction->delete();
//        return response()->json([
//            'status'=>true
//        ]);
    }
}
