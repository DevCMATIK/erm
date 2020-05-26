<?php

namespace App\Domain\System\Role;

use App\App\Traits\Model\Sluggable;
use App\App\Traits\Permissions\Permissible;
use App\Domain\System\Menu\Menu;
use App\Domain\System\User\User;
use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    use Sluggable,Permissible;

    protected $fillable = [
        'name','slug','permissions'
    ];


	public function destroyRelationships()
	{
		//users
		if(!optional($this->users)->first() || $this->users()->detach()) {
			if (!optional($this->menus)->first() || $this->menus()->detach()) {
				return true;
			}
		}
		return false;
	}

    public function menus()
    {
        return $this->belongsToMany(Menu::class,'menu_roles','role_id','menu_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_roles','role_id','user_id');
    }
}
