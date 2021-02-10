<?php

namespace App\Repositories\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Interfaces\Admin\RoleInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;

/**
 * Class RoleRepository
 * @package App\Repositories\Admin
 * @property-read Role $model
 */
class RoleRepository extends AbstractRepository implements RoleInterface
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
        return Role::class;
    }

    public function index()
    {
        $data['entities'] = $this->model->where('id', '>', 1)->latest()->get();
        return view('roles.index', $data);
    }

    public function create($attributes=[])
    {
        $data['permissions'] = Permission::all();
        return view('roles.create', $data);
    }

    public function store()
    {
        try{
            $name = request(['name']);
            $role = $this->model->create($name);
            $permIds = request()->permissions;
            $permissions = Permission::findMany($permIds);
            $role->syncPermissions($permissions);
            return redirect('/roles')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your role has been saved successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }catch(\Exception $e){
            return redirect('/roles')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$e->getMessage()."',showConfirmButton: false,timer: 3000});});</script>");
        }
        
    }

    public function edit($id)
    {
        $data['permissions'] = Permission::all();
        $data['entity'] = $this->model->find($id);
        return view('roles.edit', $data);
    }

    public function update($entityId=0, $attributes=[])
    {
        try{
            $name = request(['name']);
            $role = $this->model->find($entityId);
            $role->name = request()->name;
            $role->save();
            $permIds = request()->permissions;
            $permissions = Permission::findMany($permIds);
            $role->syncPermissions($permissions);
            return redirect('/roles')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your role has been updated successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }catch(\Exception $e){
            return redirect('/roles')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: '".$e->getMessage()."',showConfirmButton: false,timer: 3000});});</script>");
        }
    }

    public function destroy($id)
    {
        $entity = $this->model->find($id);
        if($entity->users()->count() > 0){
            return redirect()->back()->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'error',title: 'This role is in use!!!',showConfirmButton: false,timer: 3000});});</script>");
        }else {
            $entity->syncPermissions([]);
            $entity->delete();
            return redirect('/roles')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Your role has been deleted successfully!',showConfirmButton: false,timer: 3000});});</script>");
        }
    }
}
