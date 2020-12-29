<?php

namespace App\Domain\Client\Zone\Sub;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubZoneHourValue extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sub_zone_id',
        'hour_cost'
    ];

    public function sub_zone()
    {
        return $this->belongsTo(SubZone::class,'sub_zone_id','id');
    }
}
