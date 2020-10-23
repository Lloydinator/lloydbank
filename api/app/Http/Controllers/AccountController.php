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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		$account = new Account();
		$thisAccount = new StripeCustomer();
		$account->balance = $request->balance;
		$account->userid = $request->userid;
		
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
			
			// Create setup intent
			$intent = SetupIntent::create([
				'customer' => $thisCustomer->id,
			]);

			return response()->json([
				'message' => 'New account information saved.', 
				'intent' => $intent->client_secret,
			]);
		}
		else {
			return response()->json([
				'message' => 'Something went wrong.'
			]);
		}
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
