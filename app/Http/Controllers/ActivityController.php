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
    
    $categories = Category::where('user_id', $userId)->get(); //ユーザーのカテゴリ情報を取得。
    
        return view('activities.time', compact('categories'));//カテゴリの情報も返す。
    }

 public function index(Request $request)
{
    $userId = auth()->id();
    $query = Activity::where('user_id', $userId); //クエリからログインユーザーのみの情報だけを定義。
    
     $categories = Category::where('user_id', $userId)->get(); //カテゴリ情報を取得。

    // カテゴリががあるときの絞り方。
    if ($request->filled('category_id')) //カテゴリが選択されていた場合場合
    {
        $query->where('category_id', $request->category_id); //クエリからカテゴリ情報のみを取得。
    }
    
    // 絞り込まれた並び替えられたクエリ結果を取得
    $activities = $query->get();
   // クエリの結果を取得し、ページネーションを適用
$activities = $query->paginate(10);


    // 並び替えのリクエストがある場合.
    
    
    $sortOrder = 'asc';//元の並び順
    
    if ($request->filled('sort')) //並び替えの選択をしているかどうか確認
    {
        $sortOrder = $request->sort === 'date_asc' ? 'asc' : 'desc'; // date_ascが真なら昇順。偽なら降順で並べる。
    }
    $query->orderBy('start_time', $sortOrder); //スタートタイムを参考に整列。


    // 結果をビューに渡す
    return view('activities.index', compact('activities', 'categories'));
}

    
public function store(Request $request)
{
    $activity = new Activity(); //新しいアクティビティリクエストを受け取る。
    
    $activity->user_id = auth()->id(); //ログイン中のユーザーを指定、作成します。
    
    $activity->category_id = $request->input('category_id'); //アクテビティのカテゴリはリクエストで選択したカテゴリした。
    
    $startTime = new \DateTime($request->input('start_time')); //リクエストデータをdatetimeに新しいスタートタイムを設定。
    
   
    $durationInMinutes = $request->input('duration'); //入力された分数を定義
    
    $endTime = clone $startTime; //コピーを作成
    $endTime->modify("+$durationInMinutes minutes"); //作成したコピーにdurationを入力しendtime作成。
    
    $activity->start_time = $startTime; //スタートタイム設定
    $activity->end_time = $endTime; //エンドタイム設定
    $activity->duration = $durationInMinutes; //duration設定
    $activity->studied_at = $startTime; //勉強日付設定
    
    $activity->reflect = $request->has('reflect');//リクエスト内にリフレクト情報があるかないか確認。
    
    $activity->save();


    if ($activity->reflect) //リフレクトカラムが真の時
    {
        $groups = auth()->user()->groups; //ユーザーとグループの情報を取得

        foreach ($groups as $group) //所属グループをループさせる
    {
            
            $group->activities()->attach($activity->id); //アクテビティをグループに関連付け
            
            $group->save(); //保存
    }
        }
    
    return redirect()->route('activities.index')->with('success', '登録完了しました！');
}


    
    
public function show($id) //idを指定
{
    $activity = Activity::find($id); //指定されたidを表示
    return view('activities.show', compact('activity'));
}

public function edit($id) 
{
    $activity = Activity::find($id);
    $categories = Category::all(); 
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
