<?php

namespace App\Http\Manage\Group;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class UserGroupController extends Controller
{
    public function index()
    {
        $groups = Group::get();
        return view('manage.group.index',compact('groups'));
    }

    public function usersFromGroup($group_id)
    {
        $users = User::get();
        $group = Group::with('users')->findOrFail($group_id);
        return view('manage.group.users-list', compact('users','group'));
    }

    public function handleUsersFromGroup(Request $request,$group_id)
    {
        $record = Group::findOrFail($group_id);
        $record->users()->detach();
        if (isset($request->users) && $request->users != null) {
            $record->users()->sync($request->users);
        }
        return response()->json(['success' => 'Se han modificado los usuarios del grupo correctamente']);
    }
}
