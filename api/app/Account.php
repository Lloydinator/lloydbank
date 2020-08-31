<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $fillable = ['name', 'balance', 'currency_id'];
	
	public function transaction(){
		return $this->hasMany('App\Transaction', 'from');
	}
}
