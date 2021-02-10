<?php

namespace App\Observers\User;

use App\Entities\User\User;
use App\Entities\User\Wallet;
use App\Notifications\User\RegistrationNotification;
use App\Notifications\User\AdminNotification;
use App\Traits\GlobalMethods;
use App\Entities\User\Referral\ReferreeDetail;
use App\Entities\User\Referral\Referral;
use App\Notifications\User\Referral\ReferralDetailNotification;

class UserObserver
{

	use GlobalMethods;

    public function created(User $user)
    {
    	if(!$user->is_admin){
    		$user->wallet()->save(new Wallet(['amount'=>'0.00']));
    		$user->my_referral_code()->save(new ReferreeDetail(['code'=>$this->randomId('referree_details')]));
    		if(session('referee')){
	            $details = ReferreeDetail::find(session('referee'));
	            $ref = User::find($details->user_id);
	            $referral = Referral::create(['user_id'=>$user->id]);
	            $ref->referrals()->attach($referral->id);
	            session()->forget('referee');
	        }
            $user->syncPermissions(['view farms', 'view banks', 'view cards', 'view investments', 'view mandates', 'view transactions', 'view referrals', 'view wallets', 'view packages']);
    	}else {
            $user->notify(new AdminNotification($user));
        }
    }

    public function updated(User $user)
    {
        if($user->isDirty('email_verified_at')){
            $user->notify(new RegistrationNotification($user->name));
            $referreeDetail = $user->my_referral_code;
            $user->notify(new ReferralDetailNotification(explode(' ', $user->name)[0], $referreeDetail->code));
        }
    }
}
