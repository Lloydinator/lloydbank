<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxnParticipant extends Model
{
    protected $table = 'txnparticipants';
    
    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }

    public function fromUser(){
        return $this->hasOne('App\User', 'from_user_id');
    }

    public function toUser(){
        return $this->hasOne('App\User', 'to_user_id');
    }
}
