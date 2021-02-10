<?php

namespace App\Repositories\User\Referral;

use App\Entities\User\Referral\ReferreeDetail;
use App\Interfaces\User\Referral\ReferreeDetailInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;

/**
 * Class ReferreeDetailRepository
 * @package App\Repositories\User\Referral
 * @property-read ReferreeDetail $model
 */
class ReferreeDetailRepository extends AbstractRepository implements ReferreeDetailInterface
{
    protected $with = [];

    /**
     * @param App $app
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return ReferreeDetail::class;
    }
}
