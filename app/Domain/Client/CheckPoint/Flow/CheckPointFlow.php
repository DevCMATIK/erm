<?php

namespace App\Domain\Client\CheckPoint\Flow;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;

class CheckPointFlow extends Model
{
    use HasDateScopes;

    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'average_flow',
        'date'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
