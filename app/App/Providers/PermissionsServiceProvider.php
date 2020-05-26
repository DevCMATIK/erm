<?php

namespace App\App\Providers;

use App\Domain\System\Permission\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*Permission::get()->map(function ($permission) {
            Gate::define($permission->slug, function($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });*/
    }
}
