<?php

namespace App\Domain\Client\ProductionArea;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductionArea extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function zones()
    {
        return $this->belongsToMany(Zone::class,'production_area_zones','production_area_id','zone_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_production_areas','production_area_id','user_id');
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
