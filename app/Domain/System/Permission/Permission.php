<?php

namespace App\Domain\System\Permission;


use App\App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends Model implements Auditable
{
    use Sluggable, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['slug','list'];

    public static function getPermissionsArray($slug)
    {
        if ($permission = static::findBySlug($slug)) {
            $permissionsArray = array();
            foreach(explode(',',$permission->list) as $p) {
                array_push($permissionsArray, $slug.'.'.$p);
            }
            return array_values($permissionsArray);
        }
        return [];
    }
}
