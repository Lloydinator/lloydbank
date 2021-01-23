<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $fillable = ['user_id', 'phone', 'street', 'city', 'zip'];
	
	public function transactions(){
		return $this->hasMany('App\Transaction', 'from');
	}

	public function users(){
		return $this->belongsTo('App\User');
	}
}
