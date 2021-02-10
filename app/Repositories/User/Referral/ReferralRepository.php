<?php

namespace App\Repositories\User\Referral;

use App\Entities\User\Referral\Referral;
use App\Interfaces\User\Referral\ReferralInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReferralRepository
 * @package App\Repositories\User\Referral
 * @property-read Referral $model
 */
class ReferralRepository extends AbstractRepository implements ReferralInterface
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
        return Referral::class;
    }

    public function index()
    {
        $user = Auth::user();
        if($user->is_admin){
            $data['entities'] = $this->model->latest()->get();
            return view('referrals.index', $data);
        }else{
            $data['entities'] = $user->referrals()->latest()->get();
            return view('referrals.users.index', $data);
        }
    }
}
