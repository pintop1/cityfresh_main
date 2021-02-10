<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Admin\RoleInterface;
use App\Interfaces\Farm\FarmInterface;
use App\Interfaces\Farm\PackageInterface;
use App\Interfaces\Transaction\BankInterface;
use App\Interfaces\Transaction\CardInterface;
use App\Interfaces\Transaction\InvestmentInterface;
use App\Interfaces\Transaction\MandateInterface;
use App\Interfaces\Transaction\TransactionInterface;
use App\Interfaces\User\Admin\AdminInterface;
use App\Interfaces\User\Referral\ReferralInterface;
use App\Interfaces\User\Referral\ReferreeDetailInterface;
use App\Interfaces\User\UserInterface;
use App\Interfaces\SettingInterface;
//Repositories
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Farm\FarmRepository;
use App\Repositories\Farm\PackageRepository;
use App\Repositories\Transaction\BankRepository;
use App\Repositories\Transaction\CardRepository;
use App\Repositories\Transaction\InvestmentRepository;
use App\Repositories\Transaction\MandateRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\Admin\AdminRepository;
use App\Repositories\User\Referral\ReferralRepository;
use App\Repositories\User\Referral\ReferreeDetailRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\SettingRepository;

class RepositoryProvider extends ServiceProvider
{
    
    protected $repositories=[
        RoleInterface::class => RoleRepository::class,
        FarmInterface::class => FarmRepository::class,
        PackageInterface::class => PackageRepository::class,
        BankInterface::class => BankRepository::class,
        CardInterface::class => CardRepository::class,
        InvestmentInterface::class => InvestmentRepository::class,
        MandateInterface::class => MandateRepository::class,
        TransactionInterface::class => TransactionRepository::class,
        AdminInterface::class => AdminRepository::class,
        ReferralInterface::class => ReferralRepository::class,
        ReferreeDetailInterface::class => ReferreeDetailRepository::class,
        UserInterface::class => UserRepository::class,
        SettingInterface::class => SettingRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
