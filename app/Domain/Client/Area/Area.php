<?php

namespace App\Domain\Client\Area;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\Zone\Zone;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'slug','name','icon'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class,'area_id','id');
    }

    public function inZone($zone)
    {
        foreach ($this->zones as $zoneInstance) {
            if($zoneInstance->id == $zone) {
                return true;
            }
        }
        return false;
    }
}
