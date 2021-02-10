<?php

namespace App\Entities\User\Referral;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\User;
use App\Entities\Transaction\Transaction;

/**
 * Class Referral
 * @package App\Entities
 */
class Referral extends Entity
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referree()
    {
        return $this->belongsToMany(User::class, 'referral_users');
    }

    public function referral_payments()
    {
        return $this->belongsToMany(Transaction::class, 'referral_payment_transaction');
    }

    public function paid_commission()
    {
        return $this->belongsToMany(User::class, 'paid_referrals')->withPivot(['amount', 'created_at', 'updated_at']);
    }
}
