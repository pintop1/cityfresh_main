<?php

namespace App\Entities\Transaction;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\User;
use App\Entities\Transaction\Investment;

/**
 * Class Mandate
 * @package App\Entities
 */
class Mandate extends Entity
{
    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }

    public function investments()
    {
	    return $this->belongsToMany(Investment::class, 'mandate_investments');
    }
}
