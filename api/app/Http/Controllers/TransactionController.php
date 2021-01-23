<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TxnStoreRequest;
use App\Events\TransactionMade;
use App\Traits\NotificationTrait;
use App\Traits\StripeHelpersTrait;
use App\Transaction;
use App\User;

class TransactionController extends Controller
{
	use NotificationTrait;
	use StripeHelpersTrait;

	function __construct()
	{
		if (!Auth::id()){
			abort(403, 'Unauthorized');
		}
	}

	public function index(){
		$txn = Transaction::with(['user_from', 'user_to'])
							->where('publictxn', 1)
							->orderBy('created_at', 'desc')
							->get();
		return $txn;
	}
	
    public function store(TxnStoreRequest $request)
    {
		$request->validated();

		try {
			$transaction = new Transaction;

			$toCustomer = User::where('email', $request->email)
								->select(['id'])
								->get();
			$fromCustomer = User::find($request->from);

			$amount = $this->swipeThatCard($fromCustomer->account->balance, 
									$request->amount, 
									$fromCustomer->stripecustomer->customer_id) ? 
									$fromCustomer->account->balance : 
									$request->amount;

			$transaction->from = $fromCustomer->id;
			$transaction->to = $toCustomer[0]->id;
			$transaction->details = "transaction ID: ".generateRandomString(2);
			$transaction->amount = $request->amount;
			$transaction->message = scrub($request->message);
			$transaction->publictxn = $request->publictxn;

			$transaction->save();

			$toUser = User::find($toCustomer[0]->id);

			$fromCustomer->account->balance -= $amount;
			$toUser->account->balance += $request->amount;
			
			$fromCustomer->push();
			$toUser->push();

			event(new TransactionMade($transaction, $toUser));

			return response()->json([
				'message' => 'You just sent $'.$request->amount.' to '.$toUser->name
			], 201);
		}
		
		catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong. Code: '.$e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }      
	}

    public function show($id)
    {
		$txn = Transaction::with(['user_from', 'user_to'])
							->where('user_from', $id)
							->orderBy('created_at', 'desc')
							->get();
		return $txn;
	}
}