<?php

namespace App\Http\System\Notification\Controllers;

use App\Domain\System\User\User;
use App\App\Controllers\Controller;
use Sentinel;

class UserNotificationController extends Controller
{
    public function getData()
    {
	    $user = User::with(['received_notifications'])
		    ->has('received_notifications')->find(Sentinel::getUser()->id);
	    $json = array();
	    if($user){
		    foreach ($user->received_notifications as $notification) {
			    $json[] = array(
				    'id' =>  $notification->id,
				    'title' => $notification->title,
				    'start' => $notification->notification_date . "T00:00:00",
				    'end' => $notification->notification_date . "T24:00:00",
				    'description' => $notification->message,
				    'allDay' => true,
				    'className' => ($notification->pivot->readed_at == null)?'fc-event-info':'fc-event-dark'
			    );
		    }
	    }

	    return json_encode($json);
    }

    public function getNotifications()
    {
        $user_id = Sentinel::getUser()->id;
    	$user  = User::with(['unread_notifications'])
		    ->has('unread_notifications')->find($user_id);
    	$export_reminders = optional(User::with('unread_export_reminders')->has('unread_export_reminders')->find($user_id))->export_reminders;
    	return view('layouts.main.partials.notifications',compact('user','export_reminders'));
    }
}
