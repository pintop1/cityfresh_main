<?php

namespace App\Http\Resources\User;

use Shamaseen\Repository\Generator\Utility\JsonResource;
use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class WalletResource
 * @package App\Http\Resources\User
 */
class WalletResource extends JsonResource
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