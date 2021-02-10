<?php

namespace App\Entities\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\User\Wallet;
use App\Entities\Transaction\Bank;
use App\Entities\Transaction\Transaction;
use App\Entities\Transaction\Mandate;
use App\Entities\Transaction\Investment;
use App\Entities\Transaction\Card;
use App\Entities\Farm\Package;
use App\Entities\Farm\Farm;
use App\Entities\User\Referral\Referral;
use App\Entities\User\Referral\ReferreeDetail;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App\Entities
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $guarded = [];

    public function name() : string
    {
        return ucwords($this->name);
    }

    public function id() : String
    {
        return 'UID-'.str_pad($this->id,6,0,STR_PAD_LEFT);
    }

    public function wallet()
    {
	    return $this->hasOne(Wallet::class);
    }

	public function banks()
    {
	    return $this->hasMany(Bank::class);
    } 

    public function cards()
    {
	    return $this->hasMany(Card::class);
    }   

    public function farms()
    {
	    return $this->hasMany(Farm::class);
    } 

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    } 

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    } 

    public function referree()
    {
        return $this->belongsToMany(User::class, 'referral_users');
    }

    public function referrals()
    {
        return $this->belongsToMany(Referral::class, 'referral_users');
    }

    public function paid_commission()
    {
        return $this->belongsToMany(Referral::class, 'paid_referrals')->withPivot(['amount', 'created_at', 'updated_at']);
    }

    public function my_referral_code()
    {
        return $this->hasOne(ReferreeDetail::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    } 

    public function mandates()
    {
        return $this->hasMany(Mandate::class);
    } 

    public function status() : string
    {
        $status = $this->is_active;
        switch ($status) {
            case true:
                return '<span class="badge badge-success">Active</span>';
                break;

            case false:
                return '<span class="badge badge-danger">Restricted</span>';
                break;
            
            default:
                break;
        }
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
