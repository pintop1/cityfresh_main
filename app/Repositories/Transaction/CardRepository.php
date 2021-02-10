<?php

namespace App\Repositories\Transaction;

use App\Entities\Transaction\Card;
use App\Interfaces\Transaction\CardInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use App\Traits\GlobalMethods;
use Illuminate\Support\Facades\Auth;

/**
 * Class CardRepository
 * @package App\Repositories\Transaction
 * @property-read Card $model
 */
class CardRepository extends AbstractRepository implements CardInterface
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
        return Card::class;
    }

    public function addCard()
    {
        $url = str_replace('-', '/', request()->from);
        $response = $this->initiateCardLink($url);
        return redirect()->away($response['data']['authorization_url']);
    }

    private function initiateCardLink($callback){
      $user = Auth::user();
      $param = [
        "email"=>$user->email,
        "amount"=>"10000",
        "currency"=>"NGN",
        "callback_url"=>route('card.process'),
        'metadata' => [
            'url'=>$callback,
        ]
      ];
      $data = $this->paystackPost("https://api.paystack.co/transaction/initialize", $param);
      return $data;
    }

    public function destroy($id){
        $item = $this->model->findOrFail($id);
        foreach($item->transactions as $trans){
            $trans->cards()->detach($item->id);
        }
        $item->delete();
        return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your card has been deleted!',showConfirmButton: false,timer: 1500});});</script>");
    }
}
