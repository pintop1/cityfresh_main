<?php

namespace App\Http\Controllers\User\Referral;

use App\Http\Requests\User\Referral\ReferralRequest;
use App\Http\Resources\User\Referral\ReferralResource;
use App\Interfaces\User\Referral\ReferralInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class ReferralController
 * @package App\Http\Controllers\User\Referral
 * @property-read ReferralInterface $interface
 */
class ReferralController extends Controller
{

    protected $routeIndex = 'referrals';

    protected $pageTitle = 'Referral';
    protected $createRoute = 'referrals.create';

    protected $viewIndex = 'referrals.index';
    protected $viewCreate = 'referrals.create';
    protected $viewEdit = 'referrals.edit';
    protected $viewShow = 'referrals.show';

    /**
     * ReferralController constructor.
     * @param ReferralInterface $interface
     * @param ReferralRequest $request
     * @param ReferralResource $resource
     */
    public function __construct(ReferralInterface $interface, ReferralRequest $request)
    {
        parent::__construct($interface, $request, new  ReferralResource([]));
        $this->middleware('can:view referrals', ['only' => ['index', 'show']]);
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
