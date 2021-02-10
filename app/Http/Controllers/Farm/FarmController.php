<?php

namespace App\Http\Controllers\Farm;

use App\Http\Requests\Farm\FarmRequest;
use App\Http\Resources\Farm\FarmResource;
use App\Interfaces\Farm\FarmInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class FarmController
 * @package App\Http\Controllers\Farm
 * @property-read FarmInterface $interface
 */
class FarmController extends Controller
{

    protected $routeIndex = 'farms';

    protected $pageTitle = 'Farm';
    protected $createRoute = 'farms.create';

    protected $viewIndex = 'farms.index';
    protected $viewCreate = 'farms.create';
    protected $viewEdit = 'farms.edit';
    protected $viewShow = 'farms.show';

    /**
     * FarmController constructor.
     * @param FarmInterface $interface
     * @param FarmRequest $request
     * @param FarmResource $resource
     */
    public function __construct(FarmInterface $interface, FarmRequest $request)
    {
        parent::__construct($interface, $request, new  FarmResource([]));
        $this->middleware('can:view farms', ['only' => ['index', 'show']]);
        $this->middleware('can:create farms', ['only' => ['create', 'store']]);
        $this->middleware('can:edit farms', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete farms', ['only' => ['destroy']]);
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
        return $this->interface->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->interface->edit($id);
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

    public function invest($id)
    {
        return $this->interface->invest($id);
    }

    public function addToPackage($slug)
    {
        return $this->interface->addToPackage($slug);
    }
}
