<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Requests\Transaction\InvestmentRequest;
use App\Http\Resources\Transaction\InvestmentResource;
use App\Interfaces\Transaction\InvestmentInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class InvestmentController
 * @package App\Http\Controllers\Transaction
 * @property-read InvestmentInterface $interface
 */
class InvestmentController extends Controller
{

    protected $routeIndex = 'investments';

    protected $pageTitle = 'Investment';
    protected $createRoute = 'investments.create';

    protected $viewIndex = 'investments.index';
    protected $viewCreate = 'investments.create';
    protected $viewEdit = 'investments.edit';
    protected $viewShow = 'investments.show';

    /**
     * InvestmentController constructor.
     * @param InvestmentInterface $interface
     * @param InvestmentRequest $request
     * @param InvestmentResource $resource
     */
    public function __construct(InvestmentInterface $interface, InvestmentRequest $request)
    {
        parent::__construct($interface, $request, new  InvestmentResource([]));
        $this->middleware('can:view investments', ['only' => ['index', 'show']]);
        $this->middleware('can:edit investments', ['only' => ['edit', 'update', 'changeStatus']]);
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
        return $this->interface->create();
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
