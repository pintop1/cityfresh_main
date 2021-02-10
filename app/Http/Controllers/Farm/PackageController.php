<?php

namespace App\Http\Controllers\Farm;

use App\Http\Requests\Farm\PackageRequest;
use App\Http\Resources\Farm\PackageResource;
use App\Interfaces\Farm\PackageInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class PackageController
 * @package App\Http\Controllers\Farm
 * @property-read PackageInterface $interface
 */
class PackageController extends Controller
{

    protected $routeIndex = 'packages';

    protected $pageTitle = 'Package';
    protected $createRoute = 'packages.create';

    protected $viewIndex = 'packages.index';
    protected $viewCreate = 'packages.create';
    protected $viewEdit = 'packages.edit';
    protected $viewShow = 'packages.show';

    /**
     * PackageController constructor.
     * @param PackageInterface $interface
     * @param PackageRequest $request
     * @param PackageResource $resource
     */
    public function __construct(PackageInterface $interface, PackageRequest $request)
    {
        parent::__construct($interface, $request, new  PackageResource([]));
        $this->middleware('can:view packages', ['only' => ['index', 'show']]);
        $this->middleware('can:create packages', ['only' => ['create', 'store']]);
        $this->middleware('can:edit packages', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete packages', ['only' => ['destroy']]);
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
}
