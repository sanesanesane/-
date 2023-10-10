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
        $categories = Category::all();
        return view('activities.time', compact('categories'));
    }

    public function index()
    {
        $activities = Activity::all(); 
        return view('activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $activity = new Activity($request->all());
        $activity->user_id = auth()->id();

        $startTime = new \DateTime($request->input('studied_at'));
        $activity->start_time = $startTime;

        $durationInMinutes = $request->input('duration');
        $endTime = clone $startTime;
        $endTime->modify("+$durationInMinutes minutes");
        $activity->end_time = $endTime;
        // start_time と studied_at を同じ値に設定
    $activity->studied_at = $activity->start_time;
    $activity->save();
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
    $activity = Activity::findOrFail($id);
    $activity->update($request->all());
    return redirect()->route('activities.index')->with('success', 'Activity updated successfully!');
}

public function destroy($id)
{
    $activity = Activity::findOrFail($id);
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
    ->where('studied_at', '=<',$endOfWeek)
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
