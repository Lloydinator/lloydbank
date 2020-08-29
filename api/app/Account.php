<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $fillable = ['name', 'balance'];
	
	public function transaction(){
		return $this->hasMany('App\Transaction');
	}
}