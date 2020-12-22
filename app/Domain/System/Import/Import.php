<?php

namespace App\Domain\System\Import;

use App\App\Traits\Model\Sluggable;
use App\App\Traits\Roles\RoleableEntity;
use App\Domain\System\Role\Role;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Import extends Model implements Auditable
{
    use Sluggable,RoleableEntity, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'slug','name','fields','description','offset','ignore_header'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_imports','import_id','role_id');
    }

    public function files()
    {
        return $this->hasMany(ImportFile::class,'import_id','id');
    }

    public function getFieldsArray()
    {
        return explode(',',$this->fields);
    }
}
