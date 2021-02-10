<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Interfaces\User\UserInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class UserController
 * @package App\Http\Controllers\User
 * @property-read UserInterface $interface
 */
class UserController extends Controller
{

    protected $routeIndex = 'users';

    protected $pageTitle = 'User';
    protected $createRoute = 'users.create';

    protected $viewIndex = 'users.index';
    protected $viewCreate = 'users.create';
    protected $viewEdit = 'users.edit';
    protected $viewShow = 'users.show';

    /**
     * UserController constructor.
     * @param UserInterface $interface
     * @param UserRequest $request
     * @param UserResource $resource
     */
    public function __construct(UserInterface $interface, UserRequest $request)
    {
        parent::__construct($interface, $request, new  UserResource([]));
        $this->middleware('can:edit users', ['only' => ['perm']]);
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
        return $this->interface->update($id, $this->request);
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

    public function profile()
    {
        return $this->interface->profile();
    }

    public function verify_referee($ref)
    {
        return $this->interface->verify_referee($ref);
    }

    public function perm($id)
    {
        return $this->interface->perm($id);
    }
}
