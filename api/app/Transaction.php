<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
	
	public function accounts(){
		return $this->belongsTo('App\Account');
	}

	public function user_from(){
		return $this->belongsTo('App\User', 'from');
	}

	public function user_to(){
		return $this->belongsTo('App\User', 'to');
	}
}

