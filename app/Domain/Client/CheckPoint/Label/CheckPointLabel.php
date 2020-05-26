<?php

namespace App\Domain\Client\CheckPoint\Label;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;

class CheckPointLabel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'device_id',
        'label'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
