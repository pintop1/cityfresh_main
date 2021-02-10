<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Requests\Transaction\CardRequest;
use App\Http\Resources\Transaction\CardResource;
use App\Interfaces\Transaction\CardInterface;
use Shamaseen\Repository\Generator\Utility\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalMethods;
use App\Entities\Transaction\Card;
use App\Entities\Transaction\Transaction;

/**
 * Class CardController
 * @package App\Http\Controllers\Transaction
 * @property-read CardInterface $interface
 */
class CardController extends Controller
{
    use GlobalMethods;

    protected $routeIndex = 'cards';

    protected $pageTitle = 'Card';
    protected $createRoute = 'cards.create';

    protected $viewIndex = 'cards.index';
    protected $viewCreate = 'cards.create';
    protected $viewEdit = 'cards.edit';
    protected $viewShow = 'cards.show';

    /**
     * CardController constructor.
     * @param CardInterface $interface
     * @param CardRequest $request
     * @param CardResource $resource
     */
    public function __construct(CardInterface $interface, CardRequest $request)
    {
        parent::__construct($interface, $request, new  CardResource([]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return parent::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return parent::edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->interface->destroy($id);
    }

    public function addCard()
    {
        return $this->interface->addCard();
    }

    public function verifyPayment()
    {
        $user = Auth::user();
        $data = $this->paystackGet("https://api.paystack.co/transaction/verify/".request()->reference);
        if($data->status){
            $card = Card::create(['details'=>$data->data->authorization]);
            $user->cards()->save($card);
            $dataa = [
                'amount'=>"100",
                'type'=>'debit',
                'description'=>'Payment card confirmation charge',
                'payment_option'=>'Card',
                'reference'=>request()->reference,
                'status'=>'success',
            ];
            $transaction = Transaction::create(['details'=>$dataa]);
            $card->transactions()->attach($transaction->id);
            $user->transactions()->save($transaction);
            return redirect($data->data->metadata->url)->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your card has been saved',showConfirmButton: false,timer: 1500});});</script>");
        }else {
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$data->message."',showConfirmButton: false,timer: 1500});});</script>");
        }
    }
}
