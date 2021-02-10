<?php

namespace App\Entities\Transaction;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\Transaction\Bank;
use App\Entities\Transaction\Card;
use App\Entities\Transaction\Investment;
use App\Entities\User\User;
use App\Entities\User\Referral\Referral;

/**
 * Class Transaction
 * @package App\Entities
 */
class Transaction extends Entity
{
    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }

    public function banks()
    {
	    return $this->belongsToMany(Bank::class, 'transaction_banks');
    }

    public function cards()
    {
	    return $this->belongsToMany(Card::class, 'transaction_cards');
    }

    public function investments()
    {
	    return $this->belongsToMany(Investment::class, 'investments_transactions');
    }

    public function referral_payments()
    {
        return $this->belongsToMany(Referral::class, 'referral_payment_transaction');
    }

    public function setDetailsAttribute($value) {
        $this->attributes['details'] = json_encode($value);
    } 

    public function data(){
        return json_decode($this->details);
    }

    public function status() : string
    {
        $status = $this->data()->status;
        switch (strtolower($status)) {
            case 'pending':
                return '<span class="badge badge-warning">Pending</span>';
                break;

            case 'failed':
                return '<span class="badge badge-danger">Failed</span>';
                break;

            case 'success':
                return '<span class="badge badge-success">Success</span>';
                break;
            
            default:
                break;
        }
    }

    public function type()
    {
        $type = $this->data()->type;
        switch (strtolower($type)) {
            case 'credit':
                return '<span class="badge badge-success text-bold">Credit</credit>';
                break;

            case 'debit':
                return '<span class="badge badge-danger text-bold">Debit</credit>';
                break;

            case 'withdrawal':
                return '<span class="badge badge-danger text-bold">Withdrawal</credit>';
                break;

            case 'earnings':
                return '<span class="badge badge-success text-bold">Earnings</credit>';
                break;
            
            default:
                # code...
                break;
        }
    }
}
