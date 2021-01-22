<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;
use App\StripeCustomer;
use Stripe\StripeClient;
use Stripe\SetupIntent;
use Stripe\Stripe;

class AccountController extends Controller
{
	public $apiKey;

	public function __construct(){
		$this->apiKey = env('STRIPE_SECRET');
		Stripe::setApiKey($this->apiKey);
	}

    public function store(Request $request)
    {
		$account = new Account();
		$account->user_id = $request->user_id;
		$account->phone = $request->phone;
		$account->street = $request->street;
		$account->city = $request->city;
		$account->zip = $request->zip;
		
		if ($account->save()){
			// Create Stripe customer
			$customer = new StripeClient($this->apiKey);
			$thisCustomer = $customer->customers->create([
				'email' => User::find($request->user_id)->email
			]);

			// Save Stripe customer info to db
			$thisAccount = new StripeCustomer();
			$thisAccount->customer_id = $thisCustomer->id;
			$thisAccount->user_id = $request->user_id;
			$thisAccount->save();

			return response()->json([
				'message' => 'Account created. Your info will load in a bit...'
			], 201);
		}
		else {
			return response()->json([
				'message' => 'Something went wrong.'
			]);
		}
	}
	
	public function setupIntent(Request $request)
	{
		// Create setup intent
		if (Account::where('user_id', $request->id)->exists()){
			$intent = SetupIntent::create([
				'customer' => User::find($request->id)
									->stripecustomer
									->customer_id,
			]);
			return response()->json([
				'message' => 'Setting up your card.', 
				'intent' => $intent->client_secret,
			]);
		}
		else {
			return response()->json([
				'message' => 'No account found to create an intent.', 
			], 400);
		}
	}
	
    public function show()
    {
        if (User::where('id', Auth::id())->exists()){
			$account = User::with(['account', 'stripecustomer'])
							->where('id', Auth::id())
							->get()
							->toJson(JSON_PRETTY_PRINT);
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

		$card = \Stripe\PaymentMethod::all([
				'customer' => $customer[0]->stripecustomer->customer_id,
				'type' => 'card',
			]
		);
		return count($card->data) === 0 ? null: $card->data[0];
	}
}
