<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $fillable = ['balance', 'userid'];
	
	public function transactions(){
		return $this->hasMany('App\Transaction', 'from');
	}

	public function users(){
		return $this->belongsTo('App\User');
	}
}
