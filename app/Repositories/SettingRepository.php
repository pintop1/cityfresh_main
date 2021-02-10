<?php

namespace App\Repositories;

use App\Entities\Setting;
use App\Interfaces\SettingInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @property-read Setting $model
 */
class SettingRepository extends AbstractRepository implements SettingInterface
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
        return Setting::class;
    }
}
