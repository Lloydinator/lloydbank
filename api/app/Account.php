<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $fillable = ['balance', 'userid'];
	
	public function transactions(){
		return $this->belongsToMany('App\Transaction', 'account_transaction', 'account_id', 'transaction_id');
	}

	public function users(){
		return $this->belongsTo('App\User');
	}
}
