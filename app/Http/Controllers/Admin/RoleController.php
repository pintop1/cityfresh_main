<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Interfaces\Admin\RoleInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 * @property-read RoleInterface $interface
 */
class RoleController extends Controller
{

    protected $routeIndex = 'roles';

    protected $pageTitle = 'Role';
    protected $createRoute = 'roles.create';

    protected $viewIndex = 'roles.index';
    protected $viewCreate = 'roles.create';
    protected $viewEdit = 'roles.edit';
    protected $viewShow = 'roles.show';

    /**
     * RoleController constructor.
     * @param RoleInterface $interface
     * @param RoleRequest $request
     * @param RoleResource $resource
     */
    public function __construct(RoleInterface $interface, RoleRequest $request)
    {
        parent::__construct($interface, $request, new  RoleResource([]));
        $this->middleware('can:view roles', ['only' => ['index', 'show']]);
        $this->middleware('can:create roles', ['only' => ['create', 'store']]);
        $this->middleware('can:edit roles', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete roles', ['only' => ['destroy']]);
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
