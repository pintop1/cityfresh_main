<?php

namespace App\Http\Controllers\User\Referral;

use App\Http\Requests\User\Referral\ReferreeDetailRequest;
use App\Http\Resources\User\Referral\ReferreeDetailResource;
use App\Interfaces\User\Referral\ReferreeDetailInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class ReferreeDetailController
 * @package App\Http\Controllers\User\Referral
 * @property-read ReferreeDetailInterface $interface
 */
class ReferreeDetailController extends Controller
{

    protected $routeIndex = 'referreeDetails';

    protected $pageTitle = 'ReferreeDetail';
    protected $createRoute = 'referreeDetails.create';

    protected $viewIndex = 'referreeDetails.index';
    protected $viewCreate = 'referreeDetails.create';
    protected $viewEdit = 'referreeDetails.edit';
    protected $viewShow = 'referreeDetails.show';

    /**
     * ReferreeDetailController constructor.
     * @param ReferreeDetailInterface $interface
     * @param ReferreeDetailRequest $request
     * @param ReferreeDetailResource $resource
     */
    public function __construct(ReferreeDetailInterface $interface, ReferreeDetailRequest $request)
    {
        parent::__construct($interface, $request, new  ReferreeDetailResource([]));
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
        return parent::destroy($id);
    }
}
