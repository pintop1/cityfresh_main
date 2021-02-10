<?php

namespace App\Repositories\Transaction;

use App\Entities\Transaction\Investment;
use App\Entities\Transaction\Transaction;
use App\Entities\Farm\Farm;
use App\Interfaces\Transaction\InvestmentInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalMethods;

/**
 * Class InvestmentRepository
 * @package App\Repositories\Transaction
 * @property-read Investment $model
 */
class InvestmentRepository extends AbstractRepository implements InvestmentInterface
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
        return Investment::class;
    }

    public function index()
    {
        $user = Auth::user();
        if($user->is_admin){
            $data['entities'] = $this->model->latest()->get();
            return view('investments.index', $data);
        }else {
            $data['entities'] = $user->investments()->latest()->get();
            return view('investments.users.index', $data);
        }
    }

    public function store()
    {
        $user = Auth::user();
        $farm = Farm::findOrFail(request()->farm);
        $units = request()->units;
        $from = explode('|', request()->from);
        $totalBuying = $units * $farm->price_per_unit;
        if($units < 1){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Minimum units allowed is 1 unit!',showConfirmButton: false,timer: 3000});});</script>");
        }else if($units > $farm->available_units){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Please select units in the range of the available units!',showConfirmButton: false,timer: 3000});});</script>");
        }else {
            if($from[0] == 'wallet'){
                if($totalBuying > $user->wallet->amount){
                    return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'You don\'t have enough funds in your wallet to perform this transaction!',showConfirmButton: false,timer: 3000});});</script>");
                }else {
                    $newB = $user->wallet->amount - $totalBuying;
                    $user->wallet->update(['amount'=>$newB]);
                    $investment = $this->saveInvestment($farm, $totalBuying, $units, 'wallet', $user, 'success', 'pending', request());
                    return redirect('/investments')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your investment has been saved successfully!',showConfirmButton: false,timer: 3000});});</script>");
                }
            }elseif($from[0] == 'bank'){
                $investment = $this->saveInvestment($farm, $totalBuying, $units, 'bank transfer', $user, 'pending', 'queued', request());
                return redirect('/investments')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your investment has been saved successfully!',showConfirmButton: false,timer: 3000});});</script>");
            }elseif($from[0] == 'card'){
                if($totalBuying > 250000){
                    return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Maximum allowed card transaction is ₦250,000!',showConfirmButton: false,timer: 3000});});</script>");
                }else{
                    $pay = $this->initiateCardLink($from[1], $totalBuying);
                    if($pay['status']){
                        $investment = $this->saveInvestment($farm, $totalBuying, $units, 'card', $user, 'success', 'pending', request(), $from[1]);
                        return redirect('/investments')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your investment has been saved successfully!',showConfirmButton: false,timer: 3000});});</script>");
                    }else {
                        return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$pay['message']."',showConfirmButton: false,timer: 3000});});</script>");
                    }
                }
                
            }
        }
    }

    private function saveInvestment($farm, $amount, $units, $from, $user, $status, $status2, $request=[], $card = null){
        $newU = $farm->available_units - $units;
        $rollover['rollover'] = false;
        if($request->rollover){
            $rollover['rollover'] = true;
            $rollover['type'] = $request->rollover_type;
        }
        $invData = [
            'units'=>$units,
            'amount'=>$amount,
            'settings' => $rollover,
            'status' => $status2,
        ];
        $dataa = [
            'amount'=>$amount,
            'type'=>'debit',
            'description'=>'Payment for investment',
            'payment_option'=>$from,
            'reference'=>$this->randomId('transactions', 'details->reference'),
            'status'=>$status,
        ];
        $investment = $this->model->create($invData);
        $transaction = Transaction::create(['details'=>$dataa]);
        $farm->investments()->attach($investment->id);
        $user->transactions()->save($transaction);
        $user->investments()->save($investment);
        $investment->transactions()->attach($transaction->id);
        $farm->available_units = $newU;
        $farm->save();
        if($card)
            $transaction->cards()->attach($card);
        return $investment;
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

    public function changeStatus($id, $action)
    {
        $investment = $this->model->findOrFail($id);
        $user = $investment->user;
        $transaction = $investment->transactions()->first();
        if($investment->status != 'queued'){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'You can only approve or decline a queued investment!',showConfirmButton: false,timer: 3000});});</script>");
        }else if($action == 'approve'){
            $investment->status = 'pending';
            $investment->save();
            $transaction->update(['details->status'=>'success']);
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Investment has been approved successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }elseif($action == 'decline'){
            $investment->status = 'declined';
            $investment->save();
            $transaction->update(['details->status'=>'failed']);
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Investment declined successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
