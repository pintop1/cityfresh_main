<?php

namespace App\Http\Controllers\User\Admin;

use App\Http\Requests\User\Admin\AdminRequest;
use App\Http\Resources\User\Admin\AdminResource;
use App\Interfaces\User\Admin\AdminInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class AdminController
 * @package App\Http\Controllers\User\Admin
 * @property-read AdminInterface $interface
 */
class AdminController extends Controller
{

    protected $routeIndex = 'admins';

    protected $pageTitle = 'Admin';
    protected $createRoute = 'admins.create';

    protected $viewIndex = 'admins.index';
    protected $viewCreate = 'admins.create';
    protected $viewEdit = 'admins.edit';
    protected $viewShow = 'admins.show';

    /**
     * AdminController constructor.
     * @param AdminInterface $interface
     * @param AdminRequest $request
     * @param AdminResource $resource
     */
    public function __construct(AdminInterface $interface, AdminRequest $request)
    {
        parent::__construct($interface, $request, new  AdminResource([]));
        $this->middleware('can:view admins', ['only' => ['index', 'show']]);
        $this->middleware('can:create admins', ['only' => ['create', 'store']]);
        $this->middleware('can:edit admins', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete admins', ['only' => ['destroy']]);
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
        return parent::destroy($id);
    }
}
