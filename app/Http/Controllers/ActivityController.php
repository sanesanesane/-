<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Activity;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Carbon; 
use Illuminate\Support\Facades\DB;



class ActivityController extends Controller
{
    public function create()
    {
        
    $userId = auth()->id();
    
    $categories = Category::where('user_id', $userId)->get();
        return view('activities.time', compact('categories'));
    }

 public function index(Request $request)
{
    $userId = auth()->id();
    // クエリをビルドする基本的なスタートポイントを設定
    $query = Activity::where('user_id', $userId);

    // カテゴリで絞り込むためのリクエストがある場合、クエリに追加
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // 並び替えのリクエストがある場合、それをクエリに適用
    $sortOrder = 'asc';
    if ($request->filled('sort')) {
        $sortOrder = $request->sort === 'date_asc' ? 'asc' : 'desc';
    }
    $query->orderBy('start_time', $sortOrder);

    // 絞り込まれた並び替えられたクエリ結果を取得
    $activities = $query->get();
    
    // ユーザーに関連するカテゴリを取得
    $categories = Category::where('user_id', $userId)->get();

    // 結果をビューに渡す
    return view('activities.index', compact('activities', 'categories'));
}

    
public function store(Request $request)
{
    $activity = new Activity();
    $activity->user_id = auth()->id();
    $activity->category_id = $request->input('category_id');
    
    // 'start_time' を設定
    $startTime = new \DateTime($request->input('start_time'));
    
    // 'duration' を元に 'end_time' を計算
    $durationInMinutes = $request->input('duration');
    $endTime = clone $startTime;
    $endTime->modify("+$durationInMinutes minutes");
    
    // モデルの属性を設定
    $activity->start_time = $startTime;
    $activity->end_time = $endTime;
    // ここで 'duration' をモデルにセットする場合
    
    $activity->duration = $durationInMinutes;

    // その他の属性を設定
    $activity->studied_at = $startTime; 
    $activity->reflect = $request->has('reflect');
    
    // モデルを保存
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
    $userId = auth()->id();  // ログインユーザーのIDを取得
    $today = Carbon::today();  // 今日の日付を取得

  
    $activities = Activity::where('user_id', $userId)
                           ->whereDate('studied_at', $today)
                           ->get();

    return view('activities.index_show', compact('activities'));
}

public function showWeek(Request $request)
{
    $userId = auth()->id(); 
    $oneWeekAgo = Carbon::now()->subWeek();

    $results = DB::table('activities')
                ->select('user_id', DB::raw('DATE(studied_at) as study_date'), DB::raw('COALESCE(SUM(duration), 0)as total_duration'))
                ->where('user_id', $userId) // ログインユーザーのデータのみに絞り込む
                ->whereBetween('studied_at', [$oneWeekAgo, Carbon::now()])
                ->groupBy('user_id', 'study_date')
                ->get();

    return view('activities.show_week', compact('results'));
}





public function showMonth(Request $request)
{
    $userId = auth()->id(); // ログインしているユーザーのIDを取得
    $oneMonthAgo = Carbon::now()->subMonth(); // 現在から1か月前の日付を取得

    $results = DB::table('activities')
                 ->select(
                     'user_id', 
                     DB::raw('DATE(studied_at) as study_date'), 
                     DB::raw('COALESCE(SUM(duration), 0) as total_duration')
                 )
                 ->where('user_id', $userId) // ログインユーザーのデータのみに絞り込む
                 ->whereBetween('studied_at', [$oneMonthAgo, Carbon::now()]) // 過去1か月間のデータを取得
                 ->groupBy('user_id', 'study_date') // ユーザーIDと勉強日ごとにグループ化
                 ->orderBy('study_date', 'asc') // 日付で昇順にソート
                 ->get();

    return view('activities.show_month', compact('results'));
}


}
