<?php

namespace App\Entities\Farm;

use Shamaseen\Repository\Generator\Utility\Entity;
use App\Entities\Farm\Farm;
use App\Entities\User\User;

/**
 * Class Package
 * @package App\Entities
 */
class Package extends Entity
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function farms()
    {
        return $this->hasMany(Farm::class);
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
}
