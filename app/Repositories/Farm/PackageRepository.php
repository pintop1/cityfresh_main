<?php

namespace App\Repositories\Farm;

use App\Entities\Farm\Package;
use App\Interfaces\Farm\PackageInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class PackageRepository
 * @package App\Repositories\Farm
 * @property-read Package $model
 */
class PackageRepository extends AbstractRepository implements PackageInterface
{
    protected $with = [];

    /**
     * @param App $app
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Package::class;
    }

    public function index()
    {
        $user = Auth::user();
        if($user->is_admin){
            $data['entities'] = $this->model->latest()->get();
            return view('packages.index', $data);
        }else {
            $data['entities'] = $this->model->whereHas('farms')->latest()->get();
            return view('packages.user.index', $data);
        }
    }

    public function store()
    {
        $user = Auth::user();
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string', 'unique:packages'],
        ]);
        if ($validator->fails()) {
            return redirect('/packages/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = request()->except(['_token']);
        $data['slug'] = Str::slug(request()->name, '-');
        $user->packages()->save(new $this->model($data));
        return redirect('/packages')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your package has been saved!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function edit($id)
    {
        $data['entity'] = $this->model->where('slug', $id)->first();
        return view('packages.edit', $data);
    }

    public function show($id)
    {
        $data['entity'] = $this->model->where('slug', $id)->first();
        return view('packages.show', $data);
    }

    public function update($entityId = 0, $attributes = [])
    {
        $entity = $this->model->find($entityId);
        $data = request()->only(['description']);
        $entity->update($data);
        return redirect('/packages/'.$entity->slug)->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your package has been updated!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function destroy($id)
    {
        $entity = $this->model->find($id);
        $farms = $entity->farms;
        foreach($farms as $farm){
            $investments = $farm->investments;
            foreach($investments as $invest){
                $transactions = $invest->transactions;
                $mandates = $invest->mandates;
                foreach($transactions as $tran)
                    $tran->delete();
                foreach($mandates as $man)
                    $man->delete();
                $invest->delete();
            }
            $farm->delete();
        }
        $entity->delete();
        return redirect('/packages')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your package has been deleted!',showConfirmButton: false,timer: 3000});});</script>");
    }
}
