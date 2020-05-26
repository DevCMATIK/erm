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
        $group = Group::findOrFail($group_id);
        $old = convertColumns($group->users);
        $group->users()->detach();
        if (isset($request->users) && $request->users != null) {
            $group->users()->sync($request->users);

        }
        addChangeLog('Usuarios del grupo :'.$group->name,'user_groups',$old,convertColumns(Group::findOrFail($group_id)->users));

        return response()->json(['success' => 'Se han modificado los usuarios del grupo correctamente']);
    }
}
