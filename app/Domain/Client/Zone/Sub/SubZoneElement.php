<?php

namespace App\Domain\Client\Zone\Sub;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubZoneElement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sub_zone_id',
        'name',
        'column'
    ];

    public function sub_zone()
    {
        return $this->belongsTo(SubZone::class,'sub_zone_id','id');
    }

    public function sub_elements()
    {
        return $this->hasMany(SubZoneSubElement::class,'sub_zone_element_id','id')->orderBy('sub_zone_sub_elements.position');
    }
}
