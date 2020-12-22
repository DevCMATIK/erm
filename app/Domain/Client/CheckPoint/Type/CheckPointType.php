<?php

namespace App\Domain\Client\CheckPoint\Type;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Inspection\CheckList\CheckList;
use App\Domain\Inspection\CheckList\Type\CheckListType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckPointType extends Model implements Auditable
{
    use Sluggable,\OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['slug','name'];

    public function check_points()
    {
        return $this->hasMany(CheckPoint::class,'type_id','id');
    }

    public function check_lists()
    {
        return $this->hasMany(CheckList::class,'check_point_type_id','id');
    }
}
