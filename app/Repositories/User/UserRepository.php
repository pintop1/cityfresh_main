<?php

namespace App\Repositories\User;

use App\Entities\User\User;
use App\Entities\User\Referral\ReferreeDetail;
use App\Interfaces\User\UserInterface;
use Shamaseen\Repository\Generator\Utility\AbstractRepository;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileUploadManager;
use App\Traits\GlobalMethods;

/**
 * Class UserRepository
 * @package App\Repositories\User
 * @property-read User $model
 */
class UserRepository extends AbstractRepository implements UserInterface
{
    use FileUploadManager, GlobalMethods;

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
        $data['entities'] = $this->model->where('is_admin', false)->latest()->get();
        return view('users.index', $data);
    }

    public function profile()
    {
        $data['user'] = Auth::user();
        $data['banks'] = $this->paystackGet('https://api.paystack.co/bank')->data;
        return view('users.profile', $data);
    }

    public function update($entityId = 0, $attributes = []){
        $data = $attributes->except(['_token', '_method', 'passport']);
        $user = User::find($entityId);
        if(request()->hasFile('passport')){
            if($user->profile_photo_path != null)
                $this->deleteSingle($user->profile_photo_path);
            $data['profile_photo_path'] = $this->uploadSingle(request('passport'), 'profile-photos');
        }
        $user->update($data);
        if($user->profile_photo_path != null && $user->dob != null && $user->address != null && $user->banks()->count() > 0 && !$user->is_complete){
            $user->update(['is_complete'=>true]);
            return redirect()->back()->with('error_bottom', "<script>$(function(){Swal.fire({title: 'Great!',text: 'Your account registration is complete!',type: 'success',showCancelButton: false,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger ml-2'});});</script>");
        }
        return redirect('/profile')->with('error_bottom', "<script>$(function(){Swal.fire({title: 'Great!',text: 'Your profile update was successful!',type: 'success',showCancelButton: false,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger ml-2'});});</script>");
    }

    public function verify_referee($ref){
        $user = ReferreeDetail::where('code', $ref)->first();
        if(!$user) return "error";
        session(['referee'=>$user->id]);
        return $user->user->name();
    } 

    public function perm($id)
    {
        $user = $this->model->find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('error_bottom', "<script>$(function(){Swal.fire({title: 'Great!',text: 'You have updated the user\'s status!',type: 'success',showCancelButton: false,confirmButtonClass: 'btn btn-success',cancelButtonClass: 'btn btn-danger ml-2'})});</script>");
    }
}
