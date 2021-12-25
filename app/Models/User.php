<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function account(){
        return $this->hasOne('App\Models\Account');
    }

    public function stripe_customer(){
		return $this->hasOne('App\Models\StripeCustomer', 'user_id');
    }
    
    public function txn_from(){
        return $this->hasMany('App\Models\TxnParticipant', 'from');
    }

    public function txn_to(){
        return $this->hasMany('App\Models\TxnParticipant', 'to');
    }
}
