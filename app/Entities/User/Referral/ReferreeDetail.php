<?php

namespace App\Entities\User\Referral;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\User;

/**
 * Class RefereeDetail
 * @package App\Entities
 */
class ReferreeDetail extends Entity
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
