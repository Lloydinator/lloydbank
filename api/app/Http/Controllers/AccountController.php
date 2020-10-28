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
	protected $thisAccount;
	
	public function __construct()
	{
		$this->thisAccount = new StripeCustomer();
	}

    public function store(Request $request)
    {
		
		$account = new Account();
		$account->userid = $request->userid;
		$account->street = $request->street;
		$account->city = $request->city;
		$account->zip = $request->zip;
		
		if ($account->save()){
			$apiKey = env('STRIPE_SECRET');
			Stripe::setApiKey($apiKey);

			// Create Stripe customer
			$customer = new StripeClient($apiKey);
			$thisCustomer = $customer->customers->create([
				'email' => User::find($request->userid)->email
			]);

			// Save Stripe customer info to db
			$thisAccount->customer_id = $thisCustomer->id;
			$thisAccount->user_id = $request->userid;
			$thisAccount->save();
		}
		else {
			return response()->json([
				'message' => 'Something went wrong.'
			]);
		}
	}
	
	public function setupIntent()
	{
		// Create setup intent
		$intent = SetupIntent::create([
			'customer' => $this->thisAccount->customer_id,
		]);

		return response()->json([
			'message' => 'New account information saved.', 
			'intent' => $intent->client_secret,
		]);
	}

    public function show()
    {
		$id = Auth::user()->id;
        if (User::where('id', $id)->exists()){
			$account = User::with(['accounts', 'stripecustomer'])->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
			return $account;
		}
		else {
			return response()->json([
				'message' => 'Not found'
			], 404);
		}
	}

	public function addCard(){
		
	}
}
