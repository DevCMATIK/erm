<?php

namespace App\Domain\Client\CheckPoint\Flow;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;

class CheckPointAuthorizedFlow extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'authorized_flow'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
