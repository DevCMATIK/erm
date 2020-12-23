<?php

namespace App\Services;



use App\Domain\System\User\User;
use OwenIt\Auditing\Models\Audit;


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
        $events = Audit::get();
        foreach ($events as $event){
            $eventsArray[$event->id] = $event->event;
        }
        return $eventsArray;
    }
}
