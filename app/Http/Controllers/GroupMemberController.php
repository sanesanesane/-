<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Carbon; 
use Illuminate\Support\Facades\DB;


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
    // groupMembersリレーションシップのクエリに対してpaginateを適用
    $members = $group->groupMembers()->paginate(10);

    return view('group_members.index', ['members' => $members, 'group' => $group]);
}


public function showActivities(Group $group, User $user)
{
    $activities = $user->activities()->where('reflect', 1)->paginate(10);
    
    return view('group_members.activities', ['activities' => $activities, 'user' => $user]);
}

public function showUserMonthActivities(User $user)
{
    $oneMonthAgo = Carbon::now()->subMonth(); // 現在から1か月前の日付を取得

    $results = DB::table('activities')
                 ->select(
                     'user_id', 
                     DB::raw('DATE(start_time) as study_date'), 
                     DB::raw('COALESCE(SUM(duration), 0) as total_duration')
                 )
                 ->where('user_id', $user->id) // 特定のユーザーのデータに絞り込む
                 ->where('reflect', 1) // reflectカラムが1のレコードのみ取得
                 ->whereBetween('start_time', [$oneMonthAgo, Carbon::now()]) // 過去1か月間のデータを取得
                 ->groupBy('user_id', 'study_date') // ユーザーIDと勉強日ごとにグループ化
                 ->orderBy('study_date', 'asc') // 日付で昇順にソート
                 ->get();

    return view('group_members.index_month', compact('results', 'user'));
}

public function showUserweekActivities(User $user)
{
    $oneWeekAgo = Carbon::now()->subweek(); 

    $results = DB::table('activities')
                 ->select(
                     'user_id', 
                     DB::raw('DATE(start_time) as study_date'), 
                     DB::raw('COALESCE(SUM(duration), 0) as total_duration')
                 )
                 ->where('user_id', $user->id) // 特定のユーザーのデータに絞り込む
                 ->where('reflect', 1) // reflectカラムが1のレコードのみ取得
                 ->whereBetween('start_time', [$oneWeekAgo, Carbon::now()]) 
                 ->groupBy('user_id', 'study_date') // ユーザーIDと勉強日ごとにグループ化
                 ->orderBy('study_date', 'asc') // 日付で昇順にソート
                 ->get();

    return view('group_members.index_week', compact('results', 'user'));
}



public function showUserActivitiesForToday(User $user)
{
    $today = Carbon::today();

    $results = DB::table('activities')
                 ->join('categories', 'activities.category_id', '=', 'categories.id')
                 ->where('activities.user_id', $user->id)  // 「activities.user_id」と明示
                 ->where('reflect', 1)
                 ->whereDate('start_time', $today)
                 ->select('activities.*', 'categories.name as category_name')
                 ->get();

    return view('group_members.index_day', compact('results', 'user'));
}





}
