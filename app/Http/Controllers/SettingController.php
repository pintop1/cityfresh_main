<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Http\Resources\SettingResource;
use App\Interfaces\SettingInterface;
use Shamaseen\Repository\Generator\Utility\Controller;

/**
 * Class SettingController
 * @package App\Http\Controllers
 * @property-read SettingInterface $interface
 */
class SettingController extends Controller
{

    protected $routeIndex = 'settings';

    protected $pageTitle = 'Setting';
    protected $createRoute = 'settings.create';

    protected $viewIndex = 'settings.index';
    protected $viewCreate = 'settings.create';
    protected $viewEdit = 'settings.edit';
    protected $viewShow = 'settings.show';

    /**
     * SettingController constructor.
     * @param SettingInterface $interface
     * @param SettingRequest $request
     * @param SettingResource $resource
     */
    public function __construct(SettingInterface $interface, SettingRequest $request)
    {
        parent::__construct($interface, $request, new  SettingResource([]));
        $this->middleware('can:view settings', ['only' => ['index', 'show']]);
        $this->middleware('can:edit settings', ['only' => ['edit', 'update']]);
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
