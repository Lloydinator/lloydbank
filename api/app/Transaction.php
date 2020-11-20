<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
	
	protected $fillable = ['from', 'to', 'details', 'amount', 'message', 'publictxn'];
	
	public function accounts(){
		return $this->belongsToMany('App\Account');
	}
}

