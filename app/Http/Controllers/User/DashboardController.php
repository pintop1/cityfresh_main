<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Transaction\Transaction;
use App\Entities\Transaction\Investment;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
    	$user = Auth::user();
    	$data['user'] = $user;
        $data['transactions'] = $user->transactions()->where('details->status', 'success')->sum('details->amount');
    	$data['ptransactions'] = $user->transactions()->where('details->status', 'pending')->sum('details->amount');
    	$data['transaction_percent'] = $this->getTransactions($user);
    	$data['investments'] = $this->getInvestments($user);
        $data['active_investment'] = $user->investments()->where('status', 'active')->sum('amount');
    	$data['active_investmentp'] = $this->getInvestments($user, true);
        $data['trans'] = $user->transactions()->latest()->limit(10)->get();
        $data['ref_percent'] = $this->getPaidReferrals($user);
        $data['bank_deposit'] = $user->transactions()->where('details->description', 'Wallet deposit')->where('details->status', 'success')->sum('details->amount');
        $data['paid_roi'] = $this->getROIPaid($user);
        $data['paid_investment'] = $user->investments()->where('status', 'paid')->sum('amount');
    	return view('users.dashboard', $data);
    }

    private function getTransactions($user, $isSum = false)
    {
    	if($isSum){
    		return $user->transactions()->sum('details->amount');
    	}
    	$success = $user->transactions()->where('details->status', 'success')->count();
    	$all = $user->transactions()->count();
    	$percent = $success > 0 ? ($success/$all)*100 : 0;
    	return $percent;
    }

    private function getInvestments($user, $isActive = false){
    	$all = $user->investments()->sum('amount');
    	if($isActive){
    		$active = $user->investments()->where('status', 'active')->sum('amount');
    		$percent = $active > 0 ? ($active/$all)*100 : 0;
    		return $percent;
    	}
    	return $all;
    }

    private function getPaidReferrals($user){
        $all = $user->referrals()->count();
        $paid = $user->paid_commission()->count();
        $val = $paid > 0 ? ($paid/$all)*100 : 0;
        return $val;
    }

    private function getROIPaid($user){
        $investments = $user->investments()->where('status', 'paid')->get();
        $roi = 0;
        foreach($investments as $invest){
            $farm = $invest->farm()->first();
            $roi += $invest->amount *($farm->roi/100);
        }
        return $roi;
    }
}
