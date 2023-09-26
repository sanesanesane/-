<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Activity;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class ActivityController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('activities.time', compact('categories'));
    }

    public function index()
    {
        $activities = Activity::all();  // すべてのアクティビティを取得
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

        $activity->save();

        return redirect()->route('activities.index')->with('success', 'Activity recorded successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function studyStats()
    {
        $chart = Charts::database(Activity::all(), 'line', 'chartjs')
                       ->groupByDay()
                       ->elementLabel("Study Time (minutes)");

        $activities = Activity::where('user_id', auth()->id())
                              ->orderBy('studied_at', 'desc')
                              ->get();

        $continuousDays = 0;
        $yesterday = now()->subDay();
        foreach ($activities as $activity) {
            if ($activity->studied_at && $activity->studied_at->toDateString() === $yesterday->toDateString()) {
                $continuousDays++;
                $yesterday = $yesterday->subDay();
            } else {
                break;
            }
        }

        $studyDays = $activities->pluck('studied_at')->unique()->count();

        return view('activities.stats', compact('studyDays', 'continuousDays', 'chart'));
    }

    public function show()
{
    $activities = Activity::where('user_id', auth()->id())
                          ->orderBy('studied_at', 'desc')
                          ->get();

    $continuousDays = 0;
    $yesterday = now()->subDay();
    foreach ($activities as $activity) {
        if ($activity->studied_at && $activity->studied_at->toDateString() === $yesterday->toDateString()) {
            $continuousDays++;
            $yesterday = $yesterday->subDay();
        } else {
            break;
        }
    }

    $studyDays = $activities->pluck('studied_at')->unique()->count();

    // チャートの作成を追加
    $chart = Charts::database(Activity::all(), 'line', 'chartjs')
                   ->groupByDay()
                   ->elementLabel("Study Time (minutes)");

    return view('activities.stats', compact('continuousDays', 'studyDays', 'activities', 'chart'));
}

}
