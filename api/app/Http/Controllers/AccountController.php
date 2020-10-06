<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::all()->toJson(JSON_PRETTY_PRINT);
		return response($accounts, 200);
    }

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

    public function show($id)
    {
        if (Account::where('id', $id)->exists()){
			$account = Account::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
			return response($account, 200);
		}
		else {
			return response()->json([
				'message' => 'Not found'
			], 404);
		}
    }
}
