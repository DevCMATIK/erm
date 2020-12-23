<?php

namespace App\Domain\Client\CheckPoint\Totalizer;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;

class CheckPointTotalizer extends Model
{
    use HasDateScopes;

    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'first_read',
        'last_read',
        'totalizer_fix',
        'input',
        'date',
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
