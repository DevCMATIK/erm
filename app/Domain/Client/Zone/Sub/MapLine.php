<?php

namespace App\Domain\Client\Zone\Sub;

use Illuminate\Database\Eloquent\Model;

class MapLine extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'point_one',
        'point_two',
        'color',
        'position',
        'one_lng',
        'one_lat',
        'two_lng',
        'two_lat'
    ];

    public function p_one () {
        return $this->belongsTo(SubZone::class,'point_one','id');
    }

    public function p_two () {
        return $this->belongsTo(SubZone::class,'point_two','id');
    }
}
