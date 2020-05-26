<?php

namespace App\App\Domain\System\Permission\Traits;

use App\Domain\System\Permission\Permission;
use App\Domain\System\Role\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasPermission
{
    public function givePermissionTo(...$permissions)
    {
        $permissions  = $this->getPermissions(Arr::flatten($permissions));

        if($permissions == null) {
            return $this;
        }

        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    public function withdrawPermissionTo($permissions)
    {
        $permissions  = $this->getPermissions(array_flatern($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach;

        return $this->givePermissionTo($permissions);
    }


    public function hasPermissionTo($permission)
    {
        if($this->permissions()->isNotEmpty()) {
            return $this->hasPermission($permission);
        }
        return $this->hasPermissionThroughRole($permission);
    }

    public function hasRole(...$roles)
    {
        return (bool) Collection::make($roles)->filter(function($role){
            return $this->roles->contains('slug',$role);
        });
    }

    protected function hasPermissionThroughRole($permission)
    {
        return (bool) $permission->roles->filter(function($role){
            return $this->roles->contains($role);
        });
    }

    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug',$permission->slug)->count();
    }

    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
