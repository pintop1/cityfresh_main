<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\WalletRequest;
use App\Http\Resources\User\WalletResource;
use App\Interfaces\User\WalletInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class WalletController
 * @package App\Http\Controllers\User
 * @property-read WalletInterface $interface
 */
class WalletController extends Controller
{

    protected $routeIndex = 'wallets';

    protected $pageTitle = 'Wallet';
    protected $createRoute = 'wallets.create';

    protected $viewIndex = 'wallets.index';
    protected $viewCreate = 'wallets.create';
    protected $viewEdit = 'wallets.edit';
    protected $viewShow = 'wallets.show';

    /**
     * WalletController constructor.
     * @param WalletInterface $interface
     * @param WalletRequest $request
     * @param WalletResource $resource
     */
    public function __construct(WalletInterface $interface, WalletRequest $request)
    {
        parent::__construct($interface, $request, new  WalletResource([]));
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

    public function addFunds()
    {
        return $this->interface->addFunds();
    }

    public function addFundPost()
    {
        return $this->interface->addFundPost();
    }

    public function withdrawFunds()
    {
        return $this->interface->withdrawFunds();
    }

    public function withdrawFundPost()
    {
        return $this->interface->withdrawFundPost();
    }
}
