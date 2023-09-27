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
        $activity->save();
        // start_time と studied_at を同じ値に設定
    $activity->studied_at = $activity->start_time;
        return redirect()->route('activities.index')->with('success', 'Activity recorded successfully!');
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
    public function show($id)
{
    $activity = Activity::find($id);
    return view('activities.show', compact('activity'));
}

}
