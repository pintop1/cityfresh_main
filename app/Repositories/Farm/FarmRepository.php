<?php

namespace App\Repositories\Farm;

use App\Entities\Farm\Farm;
use App\Entities\Farm\Package;
use App\Interfaces\Farm\FarmInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Traits\FileUploadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Entities\Setting;

/**
 * Class FarmRepository
 * @package App\Repositories\Farm
 * @property-read Farm $model
 */
class FarmRepository extends AbstractRepository implements FarmInterface
{
    use FileUploadManager;

    protected $with = [];

    protected $routeIndex = 'farms';

    protected $pageTitle = 'Farm';
    protected $createRoute = 'farms.create';

    protected $viewIndex = 'farms.index';
    protected $userViewIndex = 'farms.users.index';
    protected $viewCreate = 'farms.create';
    protected $viewEdit = 'farms.edit';
    protected $viewShow = 'farms.show';
    protected $userViewShow = 'farms.users.show';

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
        return Farm::class;
    }

    public function create($attributes = [])
    {
        $data['packages'] = \App\Entities\Farm\Package::latest()->get();
        return view($this->viewCreate, $data);
    }

    public function index()
    {
        $user = Auth::user();
        if($user->is_admin){
            $data['entities'] = $this->model->latest()->limit(50)->get();
            return view($this->viewIndex, $data);
        }else {
            $data['entities'] = $this->model->latest()->get();
            return view($this->userViewIndex, $data);
        }
        
    }

    public function show($id)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['entity'] = $this->model->where('slug', $id)->first();
        if($user->is_admin){
            return view($this->viewShow, $data);
        }else {
            return view($this->userViewShow, $data);
        }
        
    }

    public function store()
    {
        $user = Auth::user();
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'String', Rule::unique('farms')->where(function ($query) {
                return $query->where('package_id', request()->package);
            })],
            'cover_image' => ['required'],// 'dimensions:width=200,height=200'],
            'start_date' => ['required', 'string'],
            'close_date' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'price_per_unit' => ['required', 'string'],
            'roi' => ['required', 'string'],
            'total_units' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $package = Package::find(request()->package);
        $count = $package->farms()->where('status', 'pending')->count() + $package->farms()->where('status','opened')->count();
        if($count > 0){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'There is an open or pending farm in this package!',showConfirmButton: false,timer: 3000});});</script>");
        }
        $data = request()->except(['_token', 'cover_image', 'package', 'allow_rollover']);
        $data['rollover'] = request()->allow_rollover ? true : false;
        $data['slug'] = Str::slug(request()->name, '-');
        $data['cover_image'] = $this->uploadSingle(request('cover_image'), 'farm_cover');
        $data['available_units'] = request()->total_units;
        $data['package_id'] = request()->package;
        $farm = $this->model->create($data);
        return redirect('/farmlists')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your farm has been saved!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function invest($id)
    {
        $data['user'] = Auth::user();
        $data['entity'] = $this->model->where('slug', $id)->first();
        $data['setting'] = Setting::findOrFail(2);
        return view('investments.users.create', $data);
    }

    public function addToPackage($slug)
    {
        $data['package'] = \App\Entities\Farm\Package::where('slug', $slug)->first();
        return view($this->viewCreate, $data);
    }

    public function edit($id)
    {
        $data['entity'] = $this->model->where('slug', $id)->first();
        return view('farms.edit', $data);
    }

    public function update($entityId = 0, $attributes = [])
    {
        $entity = $this->model->find($entityId);
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string'],
            'start_date' => ['required', 'string'],
            'close_date' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'price_per_unit' => ['required', 'string'],
            'roi' => ['required', 'string'],
            'total_units' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = request()->except(['_token', 'cover_image', '_method']);
        if(request()->hasFile('cover_image')){
            $this->deleteSingle($entity->cover_image);
            $data['cover_image'] = $this->uploadSingle(request('cover_image'), 'farm_cover');
        }
        $this->model->where('id', $entityId)->update($data);
        return redirect('/farmlists')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your farm has been updated!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function destroy($id)
    {
        $entity = $this->model->find($id);
        $investments = $entity->investments;
        if(count($investments) > 0){
            return redirect('/farmlists')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'Farm has investments!',showConfirmButton: false,timer: 3000});});</script>");
        }else {
            foreach($investments as $invest){
                $transactions = $invest->transactions;
                $mandates = $invest->mandates;
                foreach($transactions as $tran)
                    $tran->delete();
                foreach($mandates as $man)
                    $man->delete();
                $invest->delete();
            }
            $this->deleteSingle($entity->cover_image);
            $entity->delete();
            return redirect('/farmlists')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your farm has been deleted!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
