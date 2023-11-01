<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Activity;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Carbon; 



class ActivityController extends Controller
{
    public function create()
    {
        
    $userId = auth()->id();
    
    $categories = Category::where('user_id', $userId)->get();
        return view('activities.time', compact('categories'));
    }

    public function index()
    {
    $userId = auth()->id();
    
    $activities = Activity::where('user_id', $userId)->get();

    return view('activities.index', compact('activities'));
    }
public function store(Request $request)
{
    $activity = new Activity();
    $activity->user_id = auth()->id();
    $activity->category_id = $request->input('category_id');
    
    $startTime = new \DateTime($request->input('start_time'));
    
    $activity->start_time = $startTime;

    $durationInMinutes = $request->input('duration');
    
    $endTime = clone $startTime;
    
    $endTime->modify("+$durationInMinutes minutes");
    
    $activity->end_time = $endTime;
    // start_time と studied_at を同じ値に設定
    $activity->studied_at = $activity->start_time;

    // reflect がチェックされているかどうかを確認
    $activity->reflect = $request->has('reflect');

    $activity->save();

    if ($activity->reflect) {
        // ユーザーが所属しているすべてのグループを取得
        $groups = auth()->user()->groups;

        foreach ($groups as $group) {
            $group->total_study_time += $durationInMinutes;
            $group->save();
            
            $group->activities()->attach($activity->id);
    }
        }
    
    return redirect()->route('activities.index')->with('success', 'Activity recorded successfully!');
}


    
    
public function show($id)
{
    $activity = Activity::find($id);
    return view('activities.show', compact('activity'));
}
public function edit($id)
{
    $activity = Activity::findOrFail($id);
    $categories = Category::all(); // カテゴリを編集フォームに渡す場合
    return view('activities.edit', compact('activity', 'categories'));
}

public function update(Request $request, $id)
{
    $activity = Activity::findOrFail($id); // 最初に$activityを取得
    $oldDuration = $activity->duration;    // その後に$oldDurationを取得

    $activity->update($request->all());
    
    // reflect属性の更新
    $activity->reflect = $request->has('reflect');
    $activity->save();
    
    // 反映設定がオンの場合のみグループに反映
    if ($activity->reflect) {
        $durationDifference = $activity->duration - $oldDuration; // 差分を計算

        $groups = auth()->user()->groups;
        
        foreach ($groups as $group) {
            $group->total_study_time += $durationDifference;
            $group->save();
            
            $group->activities()->attach($activity->id);
            $group->refresh();
        }
    }
    
    return redirect()->route('activities.index')->with('success', 'Activity updated successfully!');
}


public function destroy($id)
{
    $activity = Activity::findOrFail($id);
    if ($activity->reflect) {
        $groups = auth()->user()->groups;
        foreach ($groups as $group) {
            $group->total_study_time -= $activity->duration; // durationを引く
            $group->save();
            
            $group->activities()->detach($activity->id);
            $group->refresh();
        }
    }

    $activity->delete();
    return redirect()->route('activities.index')->with('success', 'Activity deleted successfully!');
}



    

public function indexShow()
{
    $today = Carbon::today();  // 今日の日付を取得
    $activities = Activity::whereDate('studied_at', $today)->get();

    return view('activities.index_show', compact('activities'));
}

public function showWeek(Request $request)
{
    $endOfWeek = new Carbon();
    if($request->input('base_date')){
        $endOfWeek = new Carbon($request->input('base_date'));
    }
    $startOfWeek = $endOfWeek->subWeek();

    $activities = Activity::where('studied_at', '>=',$startOfWeek)
    ->where('studied_at', '<=',$endOfWeek)
    ->orderBy('studied_at', 'asc')->get();

    return view('activities.show_week', compact('activities'));
}

public function showMonth()
{
    $endOfMonth = Carbon::today();
    $startOfMonth = Carbon::today()->subMonth();
    
    $activities = Activity::where('studied_at', '>=', now()->subDays(30))->orderBy('studied_at', 'asc')->get();
    
    return view('activities.show_month', compact('activities'));
}


}
