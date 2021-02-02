<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountRequest;
use App\Traits\StripeHelpersTrait;
use App\Account;
use App\User;
use App\StripeCustomer;

class AccountController extends Controller
{
	use StripeHelpersTrait;

    public function store(AccountRequest $request)
    {
		$request->validated();

		try {
			Account::create($request->all());

			$thisCustomer = $this->createCustomer(
				User::find($request->user_id)->email
			);

			$account = new StripeCustomer();
			$account->customer_id = $thisCustomer->id;
			$account->user_id = $request->user_id;
			$account->save();

			return response()->json([
				'message' => 'Account created. Your info will load in a bit...'
			], 201);
		}
		catch(\Exception $e){
			return response()->json([
				'message' => 'Something went wrong. '.$e->getMessage()
			], 400);
		}
	}
	
	public function setupIntent(Request $request)
	{
		if (Account::where('user_id', $request->id)->exists()){
			$customer = User::find($request->id)->stripecustomer->customer_id;
			return $this->createSetupIntent($customer);
		}
	}
	
    public function show()
    {
        if (User::where('id', Auth::id())->exists()){
			$account = User::with(['account', 'stripecustomer'])
							->where('id', Auth::id())
							->get();
			return $account;
		}
		else {
			return response()->json([
				'message' => 'Not found'
			], 404);
		}
	}

	public function getCard(){
		$customer = User::with('stripecustomer')->where('id', Auth::id())->get();
		$card = $this->getPaymentMethod($customer[0]->stripecustomer->customer_id);
		return count($card->data) === 0 ? null : $card->data[0];
	}
}
