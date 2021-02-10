<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entities\Farm\Farm;

use App\Entities\Transaction\Bank;
use App\Entities\Transaction\Card;
use App\Entities\Transaction\Investment;
use App\Entities\Transaction\Mandate;
use App\Entities\Transaction\Transaction;
use App\Entities\User\Referral\Referral;
use App\Entities\User\Referral\ReferreeDetail;
use App\Entities\User\User;
use App\Entities\User\Wallet;
use App\Observers\Farm\FarmObserver;
use App\Observers\Transaction\BankObserver;
use App\Observers\Transaction\CardObserver;
use App\Observers\Transaction\InvestmentObserver;
use App\Observers\Transaction\MandateObserver;
use App\Observers\Transaction\TransactionObserver;
use App\Observers\User\Referral\ReferralObserver;
use App\Observers\User\Referral\ReferreeDetailObserver;
use App\Observers\User\UserObserver;
use App\Observers\User\WalletObserver;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Farm::observe(FarmObserver::class);
        Bank::observe(BankObserver::class);
        Card::observe(CardObserver::class);
        Investment::observe(InvestmentObserver::class);
        Mandate::observe(MandateObserver::class);
        Transaction::observe(TransactionObserver::class);
        Referral::observe(ReferralObserver::class);
        ReferreeDetail::observe(ReferreeDetailObserver::class);
        User::observe(UserObserver::class);
        Wallet::observe(WalletObserver::class);
    }
}
