<?php

namespace App\Http\System\Notification\Controllers;

use App\Domain\System\Notification\Notification;
use App\Domain\System\User\User;
use App\Http\System\Notification\Requests\StoreNotificationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class NotificationController extends Controller
{

    public function index()
    {
        return view('system.notification.index');
    }

    public function create()
    {
	    $users = User::where('id','<>',Sentinel::getUser()->id)->get();
        return view('system.notification.create',compact('users'));
    }


    public function store(StoreNotificationRequest $request)
    {
	    $user = Sentinel::getUser();
	    if($notification = Notification::create(array_merge(
		    $request->all(),
		    ['user_id' => $user->id]
	    ))) {
		    if(isset($request->users) && count($request->users) > 0) {
			    foreach($request->users as $u) {
				    $notification->receivers()->attach($u,['readed_at' => null]);
			    }
		    }
		    $notification->receivers()->attach($user->id,['readed_at' => null]);

		    return $this->getResponse('success.store');
	    } else {
		    return $this->getResponse('error.store');
	    }
    }


    public function show($id)
    {
	    $notification = Notification::with('receivers')->find($id);
	    $notification->receivers()->updateExistingPivot(Sentinel::getUser()->id,['readed_at' => Carbon::now()->toDateString()]);
	    return view('system.notification.show', compact('notification'));
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if ($notification->receivers()->detach()) {
			if($notification->delete()) {
				return $this->getResponse('success.destroy');
			} else {
				return $this->getResponse('error.destroy');
			}
        } else {
        	return response()->json(['error' => 'No se pudieron eliminar los destinatarios.'],401);
        }
    }
}
