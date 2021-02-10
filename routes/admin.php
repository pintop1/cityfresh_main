<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Farm\FarmController;
use App\Http\Controllers\Farm\PackageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\Admin\AdminController as TheAdminController;
use App\Http\Controllers\User\Referral\ReferralController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\InvestmentController;
use App\Http\Controllers\Transaction\MandateController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::group(['middleware'=>'is_admin'], function(){
	Route::get('/', [AdminController::class, '__invoke']);
	Route::get('/dashboard', [AdminController::class, '__invoke'])->name('admin.dashboard');
	Route::resource('farmlists', FarmController::class);
	Route::resource('packages', PackageController::class);
	Route::resource('users', UserController::class);
	Route::resource('referrals', ReferralController::class)->only(['index']);
	Route::resource('transactions', TransactionController::class)->only(['index']);
	Route::resource('mandates', MandateController::class)->only(['index', 'destroy', 'edit', 'update']);
	Route::resource('investments', InvestmentController::class)->only(['index']);
	Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);
	Route::resource('roles', RoleController::class);
	Route::resource('administrators', TheAdminController::class);
	Route::get('/transactions/{id}/{action}', [TransactionController::class, 'changeStatus']);
	Route::get('/users/{id}/perm', [UserController::class, 'perm']);
	Route::get('/farmlists/{slug}/create', [FarmController::class, 'addToPackage']);
	Route::get('/investments/{id}/{action}', [InvestmentController::class, 'changeStatus']);
	Route::get('/notifications', function(){
		return view('notifications.admin.index');
	});
	Route::get('/notifications/{id}', function($id){
		DB::table('notifications')->where('id', $id)->update(['read_at'=>\Carbon\Carbon::now()]);
		$notification = DB::table('notifications')->where('id', $id)->first();
		return view('notifications.admin.show', ['id'=>$id, 'notification'=>$notification]);
	});
});
