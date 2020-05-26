<?php

namespace App\App\Traits\Model;

use Illuminate\Support\Str;

trait Sluggable
{
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public static function slugExists($slug,$id)
    {
        return static::whereSlug($slug)->where('id','<>',$id)->first();
    }

    public static function findBySlug($slug)
    {
        return static::whereSlug($slug)->first();
    }

    public function scopeSlug($query,$slug)
    {
        return $query->where('slug',$slug);
    }
}
