<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class GroupController extends Controller
{
    public function dashboard()
    {
        return view('groups.dashboard'); 
    }


    
    public function create()
    {
        return view('groups.create');
    }

public function index()
{
    $user_id = auth()->id();

    $groups = DB::table('groups')
        ->join('group_members', 'groups.id', '=', 'group_members.group_id')
        ->select('groups.*', 'group_members.user_id as pivot_user_id', 'group_members.group_id as pivot_group_id', 'group_members.role as pivot_role')
        ->where('group_members.user_id', $user_id)
        ->whereNull('groups.deleted_at')
        ->get();

    return view('groups.index', compact('groups'));
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
    
// グループを作成
    $group = Group::create($data);

    // 作成者（現在のユーザー）をグループのメンバーとして追加
    $group->users()->attach(auth()->id(), 
    ['role' => 'host',
     'joined_at' => Carbon::now()
    ]);
    

    return redirect()->route('groups.index')->with('success', 'グループを作成しました。');
}

    
    public function search()
    {
        return view('groups.search');
    }
    
public function searchresults(Request $request)  // ここでRequest $requestを追加
{
    $id = $request->input('id');
    $group = Group::find($id);

    if ($group)
    {
        return redirect()->route('groups.show', $group->id);
    }
    else
    {
        return back()->withErrors(['message' => '指定されたIDのグループは存在しません。']);
    }
}
    
    public function join(Group $group)
{
    $group->users()->attach(auth()->id(), ['role' => 'member','joined_at' => now()]);
    return redirect()->route('groups.show', $group->id)->with('success', 'グループに加入しました。');
}


public function leave(Group $group)
{
    $group->users()->detach(auth()->id());
    return redirect()->route('groups.index')->with('success', 'グループを脱退しました。');
}


public function destroy(Group $group)
{
    // ユーザーがグループのホストかどうかを確認
    $isHost = $group->users()->where('user_id', auth()->id())->wherePivot('role', 'host')->exists();

    if (!$isHost) {
        return redirect()->back()->with('error', '権限がありません。');
    }

    $group->delete();
    return redirect()->route('groups.index')->with('success', 'グループを削除しました。');
}

public function edit(Group $group)
{
    // ユーザーがグループのホストかどうかを確認
    $isHost = $group->users()->where('user_id', auth()->id())->wherePivot('role', 'host')->exists();

    if (!$isHost) {
        return redirect()->back()->with('error', '権限がありません。');
    }

    return view('groups.edit', compact('group'));
}

public function update(Request $request, Group $group)
{
    // ユーザーがグループのホストかどうかを確認
    $isHost = $group->users()->where('user_id', auth()->id())->wherePivot('role', 'host')->exists();

    if (!$isHost) {
        return redirect()->back()->with('error', '権限がありません。');
    }

    // バリデーション
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // データを更新
    $group->update($data);

    return redirect()->route('groups.show', $group->id)->with('success', 'グループ情報を更新しました。');
}

public function show(Group $group) 
{
    $user_id = auth()->id();


    // 特定のグループに関連する全てのメンバーの情報をダンプ
    $members = $group->members()->get();


    // 特定のグループに属する現在のユーザーの情報をダンプ
    $member = $group->members()->where('user_id', $user_id)->first();
    

    // 特定のグループに属する現在のユーザーの役割をダンプ
    $role = $member->pivot->role ?? null;
  

    // 現在のユーザーの役割に基づいて処理
    if ($role == 'host') {
        $currentUserRole = 'host';
    } elseif ($role == 'member') {
        $currentUserRole = 'member';
    } else {
        $currentUserRole = 'null';  
    }

    return view('groups.show', compact('group', 'currentUserRole'));
}

public function statistics($groupId)
{
    $group = Group::findOrFail($groupId);
    // その他の統計データもここで取得できます。

    return view('groups.statistics', compact('group'));
}




    
}
