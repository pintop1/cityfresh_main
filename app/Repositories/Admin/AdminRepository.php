<?php

namespace App\Repositories\Admin;

use App\Entities\Admin\Admin;
use App\Interfaces\Admin\AdminInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;

/**
 * Class AdminRepository
 * @package App\Repositories\Admin
 * @property-read Admin $model
 */
class AdminRepository extends AbstractRepository implements AdminInterface
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
        return Admin::class;
    }
}
