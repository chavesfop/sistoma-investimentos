<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function add(Request $request){
        $this->validate($request, [
            'quote' => 'required|string|between:5,100',
            'transaction_date' => 'required|date',
            'quantity' => 'required|int',
            'price' => 'required|numeric|min:0.01',
            'decrement' => 'required|boolean'
        ]);

        $transaction = new Transaction;
        $transaction->user_id = $this->user->id;
        $transaction->wallet_id = $request->route('walletId');
        $transaction->quote = $request->input('quote');
        $transaction->transaction_date = $request->input('transaction_date');
        $transaction->quantity = $request->input('quantity');
        $transaction->price = $request->input('price');
        $transaction->decrement = (bool)$request->input('decrement');
        $transaction->save();

        return response()->json(['message' => 'transaction was added successfully']);
    }
}
