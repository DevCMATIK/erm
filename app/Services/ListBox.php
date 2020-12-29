<?php

namespace App\Services;

use App\Domain\System\User\User;
use App\Domain\System\Audit\Audit;

class ListBox
{
    public function getUsers()
    {
        $users = User::get();
        foreach ($users as $user){
            $usersArray[$user->user_id] = $user->first_name;
        }
        return $usersArray;
    }

    public function getEventType()
    {
        $events = Audit::get()->unique('event');
        foreach ($events as $event){
            $eventsArray[$event->event] = $event->event;
        }
        return $eventsArray;
    }
}
