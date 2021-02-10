<?php

namespace App\Http\Resources\Transaction;

use Shamaseen\Repository\Generator\Utility\JsonResource;
use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class BankResource
 * @package App\Http\Resources\Transaction
 */
class BankResource extends JsonResource
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