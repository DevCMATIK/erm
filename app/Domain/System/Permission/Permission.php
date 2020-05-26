<?php

namespace App\Domain\System\Permission;


use App\App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Sluggable;

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
