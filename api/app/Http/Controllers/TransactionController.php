<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Account;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
		$this->validate($request, [
			'from' => 'required',
			'to' => 'required',
			'amount' => 'required',
			'currency_id' => 'required',
			'message' => 'required'
		]);
		
		$txnList = Transaction::all();
		$transaction = new Transaction;
		$txnCount = $txnList->count();
		$number = $txnCount + 1;
		$amount = $request->amount;
		$from = $request->from;
		$to = $request->to;
		$currency_id = $request->currency_id;
		$message = $request->message;
		
		$newBalance = Account::find($from);
		$newBalanceTo = Account::find($to);
		
		if ($newBalance->balance > 0){
			if ($from !== $to && $amount <= $newBalance->balance){
				$transaction->from = $from;
				$transaction->to = $to;
				$transaction->details = "sample transaction ".$number;
				$transaction->amount = $amount;
				$transaction->currency_id = $currency_id;
				$transaction->message = $message;
				
				if ($transaction->save()){
					if ($currency_id == 2 ){
						$amount = $amount / 0.84;
					}
					$newBalance->balance = $newBalance->balance - $amount;
					$newBalanceTo->balance = $newBalanceTo->balance + $amount;
					$newBalance->save();
					$newBalanceTo->save();
					
					return response()->json([
						'message' => 'You just sent $'.$transaction->amount.'. Balance: $'.$newBalance->balance
					], 201);
				}
				else {
					return response()->json([
						'message' => 'Something went wrong :('
					], 400);
				}
			} 
			else {
				return response()->json([
					'message' => 'Either you\'re trying to send money to yourself or you don\'t have enough money. Try again.'
				], 400);
			}
		}
		else {
			return response()->json([
				'message' => 'You don\'t have enough money to send' 
			]);
		}
	}

    public function show($id)
    {
		$txn = Account::find($id)->transactions()->where('from', $id)->get()->toJson(JSON_PRETTY_PRINT);
		return $txn;
	}
	
	//Shouldn't be able to delete a transaction

}