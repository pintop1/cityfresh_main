<?php

namespace App\Http\Resources\Farm;

use Shamaseen\Repository\Generator\Utility\JsonResource;
use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class FarmResource
 * @package App\Http\Resources\Farm
 */
class FarmResource extends JsonResource
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