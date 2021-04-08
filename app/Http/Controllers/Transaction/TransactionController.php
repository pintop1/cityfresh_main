<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Requests\Transaction\TransactionRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Interfaces\Transaction\TransactionInterface;
use Shamaseen\Repository\Generator\Utility\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Transaction
 * @property-read TransactionInterface $interface
 */
class TransactionController extends Controller
{

    protected $routeIndex = 'transactions';

    protected $pageTitle = 'Transaction';
    protected $createRoute = 'transactions.create';

    protected $viewIndex = 'transactions.index';
    protected $viewCreate = 'transactions.create';
    protected $viewEdit = 'transactions.edit';
    protected $viewShow = 'transactions.show';

    /**
     * TransactionController constructor.
     * @param TransactionInterface $interface
     * @param TransactionRequest $request
     * @param TransactionResource $resource
     */
    public function __construct(TransactionInterface $interface, TransactionRequest $request)
    {
        parent::__construct($interface, $request, new  TransactionResource([]));
        $this->middleware('can:view transactions', ['only' => ['index', 'show', 'single']]);
        $this->middleware('can:edit packages', ['only' => ['edit', 'update', 'changeStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->interface->index();
    }

    public function single($status = 'all')
    {
        return $this->interface->single($status);
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
        return parent::destroy($id);
    }

    public function changeStatus($id, $action)
    {
        return $this->interface->changeStatus($id, $action);
    }
}
