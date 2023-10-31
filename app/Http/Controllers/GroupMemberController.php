<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;


class GroupMemberController extends Controller
{
    /**
     * Display a listing of the members of the specified group.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
public function index(Group $group)
{
    $members = $group->groupMembers;

    
    return view('group_members.index', ['members' => $members, 'group' => $group]);
}

public function showActivities(Group $group, User $user)
{
    $activities = $user->activities()->where('reflect', 1)->get();
    return view('group_members.activities', ['activities' => $activities, 'user' => $user]);
}



}
