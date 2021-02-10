<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Requests\Transaction\BankRequest;
use App\Http\Resources\Transaction\BankResource;
use App\Interfaces\Transaction\BankInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class BankController
 * @package App\Http\Controllers\Transaction
 * @property-read BankInterface $interface
 */
class BankController extends Controller
{

    protected $routeIndex = 'banks';

    protected $pageTitle = 'Bank';
    protected $createRoute = 'banks.create';

    protected $viewIndex = 'banks.index';
    protected $viewCreate = 'banks.create';
    protected $viewEdit = 'banks.edit';
    protected $viewShow = 'banks.show';

    /**
     * BankController constructor.
     * @param BankInterface $interface
     * @param BankRequest $request
     * @param BankResource $resource
     */
    public function __construct(BankInterface $interface, BankRequest $request)
    {
        parent::__construct($interface, $request, new  BankResource([]));
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
        return $this->interface->store();
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
        return $this->interface->update($id);
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
}
