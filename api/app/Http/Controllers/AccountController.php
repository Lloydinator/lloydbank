<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\User;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	/*
	public function __construct(){
		dd(Auth::user());
		if (is_null(Auth::user())){
			return response()->json([
				'message' => 'Unauthorized'
			], 400);
		}
	}
	*/
    public function store(Request $request)
    {
		$this->validate($request, [
			'balance' => 'required',
		]);
		
		$account = new Account();
		$account->name = $request->name;
		$account->balance = $request->balance;
		$account->userid = $request->userid;
		
		if ($account->save()){
			return response()->json([
				'message' => 'New account information saved.'
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
			$account = User::with('accounts')->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
			return response($account, 200);
		}
		else {
			return response()->json([
				'message' => 'Not found'
			], 404);
		}
    }
}
