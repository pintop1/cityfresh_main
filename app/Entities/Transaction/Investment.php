<?php

namespace App\Entities\Transaction;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\Farm\Farm;
use App\Entities\User\User;
use App\Entities\Transaction\Transaction;

/**
 * Class Investment
 * @package App\Entities
 */
class Investment extends Entity
{
    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }

    public function id() : String
    {
        return 'INV'.str_pad($this->id,6,0,STR_PAD_LEFT);
    }

    public function farm()
    {
	    return $this->belongsToMany(Farm::class, 'farms_investments');
    }

    public function transactions()
    {
	    return $this->belongsToMany(Transaction::class, 'investments_transactions');
    }

    public function mandates()
    {
	    return $this->belongsToMany(Investment::class, 'mandate_investments');
    }

    public function setSettingsAttribute($value) {
        $this->attributes['settings'] = json_encode($value);
    } 

    public function status() : string
    {
        $status = $this->status;
        switch ($status) {
            case 'queued':
                return '<span class="badge badge-warning">Queued</span>';
                break;

            case 'pending':
                return '<span class="badge badge-warning">Pending</span>';
                break;

            case 'declined':
                return '<span class="badge badge-danger">Declined</span>';
                break;

            case 'matured':
                return '<span class="badge badge-info">Matured</span>';
                break;

            case 'paid':
                return '<span class="badge badge-success">Paid</span>';
                break;

            case 'active':
                return '<span class="badge badge-primary">Active</span>';
                break;
            
            default:
                break;
        }
    }

    public function data(){
        return json_decode($this->settings);
    }
}
