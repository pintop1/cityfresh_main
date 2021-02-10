<?php

namespace App\Repositories\User\Admin;

use App\Entities\User\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Interfaces\User\Admin\AdminInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminRepository
 * @package App\Repositories\User\Admin
 * @property-read Admin $model
 */
class AdminRepository extends AbstractRepository implements AdminInterface
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
        return User::class;
    }

    public function index()
    {
        $data['entities'] = $this->model->where('id', '>', 1)->where('is_admin', true)->latest()->get();
        return view('admins.index', $data);
    }

    public function create($attributes=[])
    {
        $data['roles'] = Role::where('id', '>', 1)->latest()->get();
        return view('admins.create', $data);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:11', 'min:11', 'unique:users'],
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $password = explode(' ', request()->name)[0].'@cityfreshfarms'.date('Y');
        $data = [
            'name'=>request()->name, 
            'email'=>request()->email, 
            'email_verified_at'=>\Carbon\Carbon::now(), 
            'password'=>$password, 
            'phone'=>request()->phone, 
            'is_admin'=>true,
        ];
        $roles = Role::findMany(request()->roles);
        $roleAdd = [];
        foreach($roles as $role){
            $roleAdd[] = $role->name;
        }
        $user = $this->model->create($data);
        $user->syncRoles($roleAdd);
        return redirect('/administrators')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'New admin has been saved successfully!',showConfirmButton: false,timer: 3000});});</script>");
    }

    public function edit($id)
    {
        $data['roles'] = Role::where('id', '>', 1)->latest()->get();
        $data['entity'] = $this->model->find($id);
        return view('admins.edit', $data);
    }

    public function update($entityId=0, $attributes=[])
    {
        $user = $this->model->find($entityId);
        $user->name = request()->name;
        $user->save();
        $roles = Role::findMany(request()->roles);
        $roleAdd = [];
        foreach($roles as $role){
            $roleAdd[] = $role->name;
        }
        $user->syncRoles($roleAdd);
        return redirect('/administrators')->with('error_bottom', "<script>$(function(){ Swal.fire({ position: 'top-end', icon: 'success',title: 'Admin has been updated successfully!',showConfirmButton: false,timer: 3000});});</script>");
    }
}
