<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = currency;
	
	public function transaction(){
		return $this->hasOne('App\Transaction');
	}
}
