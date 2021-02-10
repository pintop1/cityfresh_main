<?php

namespace App\Repositories\User;

use App\Entities\User\Wallet;
use App\Entities\Transaction\Transaction;
use App\Interfaces\User\WalletInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalMethods;
use App\Entities\Setting;

/**
 * Class WalletRepository
 * @package App\Repositories\User
 * @property-read Wallet $model
 */
class WalletRepository extends AbstractRepository implements WalletInterface
{

    use GlobalMethods;

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
        return Wallet::class;
    }

    public function addFunds()
    {
        $data['user'] = Auth::user();
        $data['setting'] = Setting::findOrFail(2);
        return view('wallets.add_fund', $data);
    }

    public function addFundPost()
    {
        $user = Auth::user();
        $amount = request()->amount;
        $from = explode('|', request()->from);
        if($from[0] == 'card')
        {
            $pay = $this->initiateCardLink($from[1], $amount);
            if($pay['status']){
                $newB = $user->wallet->amount + $amount;
                $user->wallet->amount = $newB;
                $user->wallet->save();
                $deposit = $this->saveToWallet($amount, 'credit', 'card', 'success', $user);
                $deposit->cards()->attach($from[1]);
                return redirect('/dashboard')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your deposit was successfully made!',showConfirmButton: false,timer: 3000});});</script>");
            }else {
                return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$pay['message']."',showConfirmButton: false,timer: 3000});});</script>");
            }
        }else {
            $this->saveToWallet($amount, 'credit', 'bank transfer', 'pending', $user);
            return redirect('/transactions')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your deposit has been queued for approval!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }

    private function initiateCardLink($card_id, $amount){
        $user = Auth::user();
        $card = $user->cards()->where('id', $card_id)->first();
        $param = [
            "email"=>$user->email,
            "amount"=>$amount*100,
            "currency"=>"NGN",
            "authorization_code"=>$card->data()->authorization_code,
        ];
        $data = $this->paystackPost("https://api.paystack.co/transaction/charge_authorization", $param);
        return $data;
    }

    private function saveToWallet($amount, $type, $from, $status, $user)
    {
        $dataa = [
            'amount'=>$amount,
            'type'=>$type,
            'description'=>'Wallet deposit',
            'payment_option'=>$from,
            'reference'=>$this->randomId('transactions', 'details->reference'),
            'status'=>$status,
        ];
        $transaction = Transaction::create(['details'=>$dataa]);
        $user->transactions()->save($transaction);
        return $transaction;
    }

    public function withdrawFunds()
    {
        $data['user'] = Auth::user();
        return view('wallets.withdraw_funds', $data);
    }

    public function withdrawFundPost()
    {
        $user = Auth::user();
        $bank = $user->banks()->where('id', request()->to)->first();
        $amount = request()->amount;
        $pending = $user->transactions()->where(['details->type'=>'withdrawal', 'details->status'=>'pending'])->count();
        $wallet = $user->wallet->amount - $user->mandates()->sum('amount');
        if($pending > 0){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'You have a pending withdrawal. Please try again later!',showConfirmButton: false,timer: 3000});});</script>");
        }elseif($amount > $wallet){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Insufficient funds',showConfirmButton: false,timer: 3000});});</script>");
        }else {
            $transaction = $this->saveToWallet($amount, 'withdrawal', 'wallet', 'pending', $user);
            $user->transactions()->save($transaction);
            $bank->transactions()->attach($transaction->id);
            return redirect('/transactions')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your withdrawal has been queued for approval!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
