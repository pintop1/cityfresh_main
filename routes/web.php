<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Farm\FarmController;
use App\Http\Controllers\Farm\PackageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Transaction\CardController;
use App\Http\Controllers\Transaction\BankController;
use App\Http\Controllers\Transaction\InvestmentController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\Referral\ReferralController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/migrate-my-db', function(){
	Artisan::call('migrate:fresh', [
	   '--force' => true, '--seed' => true
	]);
});
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/verify_referree/{referree}', [UserController::class, 'verifyReferree'])->name('verify_referee');

Route::group(['middleware'=>['auth:sanctum', 'verified', 'is_user']], function(){
	Route::group(['middleware'=>'is_complete'], function(){
		Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
		Route::resource('farms', FarmController::class)->only(['show']);
		Route::get('/farms/{id}/invest', [FarmController::class, 'invest']);
		Route::resource('packages', PackageController::class)->only(['index']);
		Route::resource('investments', InvestmentController::class)->except(['destroy', 'edit', 'update']);
		Route::resource('transactions', TransactionController::class)->only(['index']);
		Route::resource('referrals', ReferralController::class)->only(['index']);
		Route::get('/add-funds', [WalletController::class, 'addFunds']);
		Route::post('/add-funds', [WalletController::class, 'addFundPost'])->name('wallet.addFunds');
		Route::get('/withdraw-fund', [WalletController::class, 'withdrawFunds']);
		Route::post('/withdraw-fund', [WalletController::class, 'withdrawFundPost'])->name('wallet.withdrawFunds');
		Route::get('/notifications', function(){
			return view('notifications.index');
		});
		Route::get('/notifications/{id}', function($id){
			DB::table('notifications')->where('id', $id)->update(['read_at'=>\Carbon\Carbon::now()]);
			$notification = DB::table('notifications')->where('id', $id)->first();
			return view('notifications.show', ['id'=>$id, 'notification'=>$notification]);
		});
		Route::get('/notifications/myaction/viewall', function(Request $request){
			$user = $request->user();
			$user->unreadNotifications->map(function($n) use($request) {
		        $n->markAsRead();
		    });
			return redirect()->back();
		});
	});
	Route::get('/profile', [UserController::class, 'profile']);
	Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
	Route::resource('cards', CardController::class)->only(['destroy']);
	Route::resource('banks', BankController::class)->only(['store', 'destroy', 'update']);
	Route::get('/card/add', [CardController::class, 'addCard']);
	Route::get('/verifyPayment', [CardController::class, 'verifyPayment'])->name('card.process');
	Route::get('/verifyPayment/invest', [InvestmentController::class, 'verifyPayment'])->name('card.process.invest');
});
Route::get('/verify_referee/{ref}', [UserController::class, 'verify_referee'])->name('verify.referee');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
