<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxnParticipant extends Model
{
    protected $table = 'txnparticipants';
    
    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }

    public function toUser(){
        return $this->hasOne('App\User', 'id', 'to_user_id');
    }

    public function fromUser(){
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }
}
