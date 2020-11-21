<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
	
	protected $fillable = ['from', 'to', 'details', 'amount', 'message', 'publictxn'];
	
	public function accounts(){
		return $this->belongsTo('App\Account');
	}

	public function txnparticipants(){
		return $this->hasOne('App\TxnParticipant');
	}
}

