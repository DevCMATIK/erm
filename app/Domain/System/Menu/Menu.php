<?php

namespace App\Domain\System\Menu;

use App\App\Traits\Model\Sluggable;
use App\App\Traits\Roles\RoleableEntity;
use App\Domain\System\Menu\Traits\NestableMenu;
use App\Domain\System\Role\Role;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Menu extends Model implements
{
    use Sluggable,RoleableEntity, NestableMenu, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'route',
        'icon',
        'parent_id',
        'position'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'menu_roles','menu_id','role_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class,'parent_id','id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class,'parent_id','id');
    }

    public static function getMenu()
    {
        return static::with('roles')->orderBy('position')->get();
    }
}
