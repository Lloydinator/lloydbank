<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeCustomer extends Model
{
    protected $table = 'stripecustomer';
    protected $fillable = ['customer_id', 'user_id'];

    public function account(){
        $this->belongsTo('App\User');
    }
}
