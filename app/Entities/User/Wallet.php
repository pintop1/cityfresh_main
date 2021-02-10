<?php

namespace App\Entities\User;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\User;

/**
 * Class Wallet
 * @package App\Entities
 */
class Wallet extends Entity
{
    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }
}
