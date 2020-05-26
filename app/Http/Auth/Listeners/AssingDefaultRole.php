<?php

namespace App\Http\Auth\Listeners;

use App\Http\Auth\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sentinel;

class AssingDefaultRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $role = Sentinel::findRoleBySlug('user');
        $role->users()->attach($event->user);
    }
}
