<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Group;


class GroupController extends Controller
{
    public function dashboard()
    {
        return view('groups.dashboard'); 
    }

    public function index()
    {
        // 現在のユーザが作成したグループを取得
    $groups = auth()->user()->groups()->where('user_id', auth()->id())->get();

    // ビューにデータを渡して表示
      return view('groups.index', compact('groups'));
      
    }
    
    public function create()
    {
        return view('groups.create');
    }
    
public function store(Request $request)
{
    $data = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('groups')->where(function ($query) use ($request) {
                return $query->where('user_id', $request->user()->id)->whereNull('deleted_at');
            })
        ],
        'description' => 'nullable|string',
    ]);
    
    $group = Group::create($data);
   // $group->members()->attach(auth()->id(), ['role' => 'host']);

    return redirect()->route('groups.index')->with('success', 'グループを作成しました。');
}

    
    public function search()
    {
        return view('groups.search');
    }
    
    public function searchresults()
    {
        return view('groups.searchresults');
    }
    
}
