<?php

namespace App\Entities\Transaction;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\User;
use App\Entities\Transaction\Transaction;

/**
 * Class Bank
 * @package App\Entities
 */
class Bank extends Entity
{
    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }

    public function transactions()
    {
	    return $this->belongsToMany(Transaction::class, 'transaction_banks');
    }

    public function data(){
    	return json_decode($this->details);
    }

    public function setDetailsAttribute($value) {
        $this->attributes['details'] = json_encode($value);
    } 
}
