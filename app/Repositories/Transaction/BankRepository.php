<?php

namespace App\Repositories\Transaction;

use App\Entities\Transaction\Bank;
use App\Interfaces\Transaction\BankInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalMethods;

/**
 * Class BankRepository
 * @package App\Repositories\Transaction
 * @property-read Bank $model
 */
class BankRepository extends AbstractRepository implements BankInterface
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
        return Bank::class;
    }

    public function index()
    {
        $user = Auth::user();
        $data['user'] = $user;
        return view('banks.index', $data);
    }

    public function store()
    {
        $user = Auth::user();
        $bank = $this->paystackGet("https://api.paystack.co/bank/resolve?account_number=".request()->account_number."&bank_code=".request()->bank);
        if($bank->status){
            $activedef = $user->banks()->where('details->default_card', true)->first();
            if($activedef)
                $activedef->update(['details->default_card'=>false]);
            $banks = $this->paystackGet('https://api.paystack.co/bank')->data;
            $id = $this->search_banks(request()->bank, $banks);
            $data['bank'] = $banks[$id];
            $data['account_number'] = request()->account_number;
            $data['account_name'] = $bank->data->account_name;
            if(request()->default_card)
                $data['default_card'] = true;
            else
                $data['default_card'] = false;
            $user->banks()->save(new Bank(['details'=>$data]));
            if($user->profile_photo_path != null && $user->dob != null && $user->address != null && !$user->is_complete){
                $user->update(['is_complete'=>true]);
                return redirect('/')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your account registration is complete!',showConfirmButton: false,timer: 1500});});</script>");
            }
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your bank has been saved!',showConfirmButton: false,timer: 1500});});</script>");
        }else {
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$bank->message."',showConfirmButton: false,timer: 3000});});</script>");
        }
    }

    public function update($entityId = 0, $attributes = [])
    {
        $user = Auth::user();
        $bank = $this->model->findOrFail($entityId);
        $activedef = $user->banks()->where('details->default_card', true)->first();
            if($activedef)
                $activedef->update(['details->default_card'=>false]);
        $bank->update(['details->default_card'=>true]);
        return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your default bank has been updated!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function destroy($id){
        $item = $this->model->findOrFail($id);
        foreach($item->transactions as $trans){
            $trans->banks()->detach($item->id);
        }
        $item->delete();
        return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your bank has been deleted!',showConfirmButton: false,timer: 3000});});</script>");
    }
}
