<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Transaction\Transaction;
use App\Entities\Transaction\Investment;
use App\Entities\User\User;
use App\Entities\User\Wallet;
use App\Entities\Farm\Farm;
use App\Entities\Transaction\Mandate;
use Auth;
use App\Traits\FileUploadManager;

class AdminController extends Controller
{
    use FileUploadManager;

    public function __invoke()
    {

    	$data['transactions'] = $this->getTransactions(true);
    	$data['transaction_percent'] = $this->getTransactions();
    	$data['investments'] = $this->getInvestments();
    	$data['active_investment'] = $this->getInvestments(true);
    	$data['users'] = $this->getUsers();
    	$data['active_user'] = $this->getUsers(true);
    	$data['farms'] = $this->getFarm();
    	$data['open_farm'] = $this->getFarm(true);
        $data['trans'] = Transaction::latest()->limit(20)->get();
        $data['mandates'] = Mandate::sum('amount');
        $data['payouts'] = $this->getPayouts();
        $data['payouts_percent'] = $this->getPayouts(true);
        $data['active_investments'] = Investment::where('status', 'active')->count();
        $data['wallets'] = Wallet::sum('amount');
        $dif = $data['wallets'] - $data['mandates'];
        $data['withdrawable'] = $dif > 0 ? ($dif/$data['wallets'])*100 : 0;
    	return view('admins.home', $data);
    }

    private function getTransactions($isSum = false)
    {
    	if($isSum){
    		return Transaction::sum('details->amount');
    	}
    	$success = Transaction::where('details->status', 'success')->count();
    	$all = Transaction::count();
    	$percent = $success > 0 ? ($success/$all)*100 : 0;
    	return $percent;
    }

    private function getInvestments($isActive = false){
    	$all = Investment::sum('amount');
    	if($isActive){
    		$active = Investment::where('status', 'active')->sum('amount');
    		$percent = $active > 0 ? ($active/$all)*100 : 0;
    		return $percent;
    	}
    	return $all;
    }

    private function getUsers($active = false){
    	$all = User::where('is_admin', false)->count();
    	if($active){
    		$actives = User::where([['is_active', true],['is_admin', false]])->count();
    		$percent = $actives > 0 ? ($actives/$all)*100 : 0;
    		return $percent;
    	}
    	return $all;
    }

    private function getFarm($open = false){
    	$all = Farm::count();
    	if($open){
    		$opened = Farm::where('status', 'opened')->count();
    		$percent = $opened > 0 ? ($opened/$all)*100 : 0;
    		return $percent;
    	}
    	return $all;
    }

    private function getPayouts($pending = false){
        $all = Transaction::where('details->type', 'withdrawal')->sum('details->amount');
        if($pending){
            $pend = Transaction::where(['details->type'=>'withdrawal', 'details->status'=>'pending'])->sum('details->amount');
            $percent = $pend > 0 ? ($pend/$all)*100 : 0;
            return $percent;
        }
        return $all;
    }

    public function profile()
    {
        $data['user'] = Auth::user();
        return view('admins.profile', $data);
    }

    public function update($id){
        $data = request()->except(['_token', '_method', 'passport']);
        $user = User::find($id);
        if(request()->hasFile('passport')){
            if($user->profile_photo_path != null)
                $this->deleteSingle($user->profile_photo_path);
            $data['profile_photo_path'] = $this->uploadSingle(request('passport'), 'profile-photos');
        }
        $user->update($data);
        return redirect()->back()->with('error_bottom', "<script>$(function(){swal({title: 'Great!',text: 'Your profile update was successful!',type: 'success',showCancelButton: false,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger ml-2'})});</script>");
    }
}
