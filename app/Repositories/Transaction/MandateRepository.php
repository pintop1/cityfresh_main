<?php

namespace App\Repositories\Transaction;

use App\Entities\Transaction\Mandate;
use App\Interfaces\Transaction\MandateInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;

/**
 * Class MandateRepository
 * @package App\Repositories\Transaction
 * @property-read Mandate $model
 */
class MandateRepository extends AbstractRepository implements MandateInterface
{
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
        return Mandate::class;
    }

    public function index()
    {
        $data['entities'] = $this->model->latest()->get();
        return view('mandates.index', $data);
    }

    public function destroy($id)
    {
        $mandate = $this->model->find($id);
        $data = ['rollover'=>false];
        $mandate->investments()->first()->update(['settings'=>$data]);
        $mandate->investments()->detach();
        $mandate->delete();
        return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Mandate deleted successfully!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function update($entityId = 0, $attributes = [])
    {
        $mandate = $this->model->find($entityId);
        $user = $mandate->user;
        $wallet = $user->wallet->amount - $user->mandates()->sum('amount');
        $theAm = request()->amount - $mandate->amount;
        if($theAm > $wallet){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Insufficient funds in withdrawable wallet!',showConfirmButton: false,timer: 3000});});</script>");
        }else {
            $mandate->update(['amount'=>request()->amount]);
            return redirect('/mandates')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Mandate updated successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
