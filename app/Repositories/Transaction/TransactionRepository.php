<?php

namespace App\Repositories\Transaction;

use App\Entities\Transaction\Transaction;
use App\Interfaces\Transaction\TransactionInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalMethods;

/**
 * Class TransactionRepository
 * @package App\Repositories\Transaction
 * @property-read Transaction $model
 */
class TransactionRepository extends AbstractRepository implements TransactionInterface
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
        return Transaction::class;
    }

    public function index()
    {
        $user = Auth::user();
        if($user->is_admin){
            $data['entities'] = $this->model->latest()->get();
            return view('transactions.index', $data);
        }else {
            $data['entities'] = $user->transactions()->latest()->get();
            return view('transactions.users.index', $data);
        }
        
    }

    public function single($status)
    {
        $user = Auth::user();
        $data['status'] = $status == 'success' ? 'Successful': ucwords($status);
        if($user->is_admin){
            if($status == 'all') $data['entities'] = $this->model->latest()->get();
            else $data['entities'] = $this->model->where('details->status', $status)->latest()->get();
            return view('transactions.index', $data);
        }else {
            if($status == 'all') $data['entities'] = $user->transactions()->latest()->get();
            else $data['entities'] = $user->transactions()->where('details->status', $status)->latest()->get();
            return view('transactions.users.index', $data);
        }
        
    }

    public function changeStatus($id, $action)
    {
        $transaction = $this->model->findOrFail($id);
        $user = $transaction->user;
        if($transaction->investments()->count() > 0){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'You cannot decline/approve an investment transaction, you have to do it via the investment itself!',showConfirmButton: false,timer: 3000});});</script>");
        }else if($action == 'approve'){
            if($transaction->data()->type == 'withdrawal'){
                $newB = $user->wallet->amount - $transaction->data()->amount;
                $user->wallet->amount = $newB;
                $user->wallet->save();
            }else if($transaction->data()->type == 'credit'){
                $newB = $user->wallet->amount + $transaction->data()->amount;
                $user->wallet->amount = $newB;
                $user->wallet->save();
            }
            $transaction->update(['details->status'=>'success']);
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Transaction approved successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }elseif($action == 'decline'){
            $transaction->update(['details->status'=>'failed']);
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Transaction declined successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
