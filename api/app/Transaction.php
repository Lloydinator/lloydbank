<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
	
	protected $fillable = ['from', 'to', 'details', 'amount', 'message', 'currency_id'];
	
	public function currency(){
		return $this->belongsTo('App\Currency');
	}
	
	public function account(){
		return $this->belongsTo('App\Account', 'from', 'to');
	}
}
