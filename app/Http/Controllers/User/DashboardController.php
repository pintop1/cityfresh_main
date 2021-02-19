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
        $data['transactions'] = $this->getTransactions($user, true);
    	$data['ptransactions'] = Transaction::where('details->status', 'pending')->sum('details->amount');
    	$data['transaction_percent'] = $this->getTransactions($user);
    	$data['investments'] = $this->getInvestments($user);
    	$data['active_investment'] = $this->getInvestments($user, true);
        $data['trans'] = $user->transactions()->latest()->limit(5)->get();
        $data['ref_percent'] = $this->getPaidReferrals($user);
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
}
