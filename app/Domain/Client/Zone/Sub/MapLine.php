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
        'position'
    ];
}
