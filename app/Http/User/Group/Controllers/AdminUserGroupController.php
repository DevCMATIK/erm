<?php

namespace App\Http\User\Group\Controllers;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class AdminUserGroupController extends Controller
{
    public function index($id)
    {
        $user = User::with('groups')->findOrFail($id);
        $groups = Group::get();
        return view('user.group.index', compact('user', 'groups'));
    }

    public function handleUserGroups(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->groups()->detach();
        if (isset($request->groups) && $request->groups != null) {
           $user->groups()->sync($request->groups);

        }

        return response()->json(['success' => 'Se han modificado los grupos del usuario']);

    }
}
