<?php

namespace App\App\Traits\Roles;

use Cartalyst\Sentinel\Roles\RoleInterface;
use Illuminate\Support\Arr;
use Sentinel;

trait RoleableEntity
{
    protected $hasPermission = false;

    public function getUserRoles()
    {
        if (isset(Sentinel::getUser()->id)) {
            if(isset(Sentinel::getUser()->roles))
            {
                return Sentinel::getUser()->roles->toArray();
            } else {
                throw new Exception('User has no roles assigned.');
            }
        }else {
            return redirect('/');
        }
    }

    public function inRole($role)
    {
        if ($role instanceof RoleInterface) {
            $roleId = $role->getRoleId();
        }

        foreach ($this->roles as $instance) {
            if ($role instanceof RoleInterface) {
                if ($instance->getRoleId() === $roleId) {
                    return true;
                }
            } else {
                if ($instance->getRoleId() == $role || $instance->getRoleSlug() == $role) {
                    return true;
                }
            }
        }

        return false;
    }

    public function userHasPermission()
    {
        return $this->searchInArray($this->entityRolesAsArray());
    }
    public function hasPermission($roles)
    {
        if(optional($roles)->first()) {
            $roles = $this->rolesAsArray($roles);
        }

        if (is_array($roles)) {
            return $this->searchInArray($roles);
        }  else {
            if (stripos($roles,',') == true) {
                return $this->searchInArray(explode(',',$roles));
            } else {
                return $this->checkPermission($roles);
            }
        }
    }

    protected function searchInArray($roles)
    {
        foreach($roles as $role){
            if(in_array($role , Arr::pluck($this->getUserRoles(),'slug'))){
                $this->hasPermission = true;
                break;
            }
        }
        return $this->hasPermission;
    }

    protected function checkPermission($roles)
    {
        if (in_array($roles,Arr::pluck($this->getUserRoles(),'slug'))) {
            return $this->hasPermission = true;
        }
    }

    public function detachAllRoles()
    {
        if(optional($this->roles)->first())
        {
            if($this->roles()->detach()) {
                return true;
            } else {
                return false;
            }
        }else {
            return true;
        }
    }

    public function attachRoles($roles)
    {
        if(optional($roles)->first()) {
            $roles = $this->rolesAsArray($roles);
        }

        if (is_array($roles)) {
            for ($i=0;$i<count($roles);$i++) {
                $role = Sentinel::findRoleBySlug($roles[$i]);
                $this->roles()->attach($role);
            }
        }  else {
            $role = Sentinel::findRoleBySlug($roles);
            $this->roles()->attach($role);
        }
    }

    public function rolesAsArray($roles)
    {
        $roles = $roles->pluck('slug');
        return Arr::flatten($roles->toArray());
    }

    public function entityRolesAsArray()
    {
        return $this->rolesAsArray($this->roles);
    }

    public static function byRole($role)
    {
        $role = Sentinel::findRoleBySlug($role);
        return $role->users()->with('roles')->get();
    }
}
