<?php

namespace App\Domain\Client\Zone;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\Area\Area;
use App\Domain\Client\ProductionArea\ProductionArea;
use App\Domain\Client\Zone\Sub\SubZone;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Zone extends Model implements Auditable
{
    use Sluggable, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['slug','name','display_name'];

    public function sub_zones()
    {
        return $this->hasMany(SubZone::class);
    }

    public function production_areas()
    {
        return $this->belongsToMany(ProductionArea::class, 'production_area_zones','zone_id','production_area_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class,'area_id','id');
    }
}
