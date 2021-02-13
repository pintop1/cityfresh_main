<?php

namespace App\Entities\Farm;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\Transaction\Investment;
use App\Entities\User\User;
use App\Entities\Farm\Package;

/**
 * Class Farm
 * @package App\Entities
 */
class Farm extends Entity
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investments()
    {
        return $this->belongsToMany(Investment::class, 'farms_investments');
    }

    public function id() : String
    {
        return 'FID'.str_pad($this->id,6,0,STR_PAD_LEFT);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getCoverImageAttribute() {
        return 'storage/'.$this->attributes['cover_image'];
    } 

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }
        return $slug;
    }

    public function status() : string
    {
        $status = $this->attributes['status'];
        switch ($status) {
            case 'pending':
                return '<span class="badge badge-warning">Coming Soon</span>';
                break;

            case 'opened':
                return '<span class="badge badge-success">Open</span>';
                break;

            case 'closed':
                return '<span class="badge badge-danger">Sold Out</span>';
                break;
            
            default:
                break;
        }
    }
}
