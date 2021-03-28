<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Requests\Transaction\MandateRequest;
use App\Http\Resources\Transaction\MandateResource;
use App\Interfaces\Transaction\MandateInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class MandateController
 * @package App\Http\Controllers\Transaction
 * @property-read MandateInterface $interface
 */
class MandateController extends Controller
{

    protected $routeIndex = 'mandates';

    protected $pageTitle = 'Mandate';
    protected $createRoute = 'mandates.create';

    protected $viewIndex = 'mandates.index';
    protected $viewCreate = 'mandates.create';
    protected $viewEdit = 'mandates.edit';
    protected $viewShow = 'mandates.show';

    /**
     * MandateController constructor.
     * @param MandateInterface $interface
     * @param MandateRequest $request
     * @param MandateResource $resource
     */
    public function __construct(MandateInterface $interface, MandateRequest $request)
    {
        parent::__construct($interface, $request, new  MandateResource([]));
        $this->middleware('can:view mandates', ['only' => ['index', 'show']]);
        $this->middleware('can:delete mandates', ['only' => ['destroy']]);
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
