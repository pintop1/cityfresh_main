<?php

namespace App\Http\Resources\User\Referral;

use Shamaseen\Repository\Generator\Utility\JsonResource;
use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class ReferreeDetailResource
 * @package App\Http\Resources\User\Referral
 */
class ReferreeDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}