<?php

namespace App\Http\Controllers;

use App\Traits\StripeHelpersTrait;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;

class AccountController extends Controller
{
    use StripeHelpersTrait;

    public function store(AccountRequest $request)
    {
        $request->validated();

        $account = Account::create($request->all());
        $user = User::find($request->user_id);

        $thisCustomer = $this->createCustomer($user->email);

        $user->stripe_customer()->create([
            'customer_id' => $thisCustomer->id,
            'user_id' => $user->id
        ]); 

        //return Redirect::route()
    }
}
