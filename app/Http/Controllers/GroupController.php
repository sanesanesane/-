<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;



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
        $user_id = auth()->id(); //ログイン中のID
        $groups = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id') //groups.id = group_members.group_idでIDを等しくする。
            ->select('groups.*', 'group_members.user_id as pivot_user_id', 'group_members.group_id as pivot_group_id', 'group_members.role as pivot_role')
            //取得するカラムを選択。*は全部取得
            ->where('group_members.user_id', $user_id) //ログイン中にメンバーグループのみ
            ->whereNull('groups.deleted_at')
            ->paginate(5); // 5つのアイテムごとにページ分割

        return view('groups.index', compact('groups'));
    }


    public function store(Request $request)
    {
        $data = $request->validate
            //バリデーション
            (
                [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('groups')->where(function ($query) use ($request) {
                            return $query->where('user_id', $request->user()->id);
                            //同じユーザーの同じ名前は不可
                        })
                    ],
                    'description' => 'nullable|string',
                ],
                [
                    // カスタムエラーメッセージ
                    'name.required' => 'カテゴリ名は必須です。',
                    'name.unique' => 'このカテゴリ名はすでに使用されています。'
                ]
            );
        // グループを作成
        $user = Auth::user();
        $group = $user->owner_groups()->create($data);
        // 作成者（現在のユーザー）をグループのメンバーとして追加
        $group->users()->attach
            //グループに以下の事を関連付け
            (
                auth()->id(),
                [
                    'role' => 'host',
                    'joined_at' => Carbon::now() //現在の時刻
                ]
            );

        // ユーザーのアクティビティの合計時間をグループの合計勉強時間に追加
        $reflectActivities = auth()->user()->activities()->where('reflect', true)->get(); //データをフィルタリング
        $totalUserStudyTime = $reflectActivities->sum('duration'); //durationを合計する

        foreach ($reflectActivities as $activity) {
            $group->activities()->attach($activity->id);  // アクティビティをグループに関連付け
        }

        $group->save();

        return redirect()->route('groups.index')->with('success', 'グループを作成しました。');
    }

    public function search()
    {
        return view('groups.search');
    }

    public function searchresults(Request $request)  // ここでRequest $requestを追加
    {
        $id = $request->input('id'); //idは入力されたもの
        $group = Group::find($id); //グループを見つける。
        if ($group) {
            return redirect()->route('groups.show', $group->id); //ページにジャンプ
        } else {
            return back()->withErrors(['message' => '指定されたIDのグループは存在しません。']);
        }
    }

    public function join(Group $group)
    {
        $reflectActivities = auth()->user()->activities()->where('reflect', true)->get();
        $totalUserStudyTime = $reflectActivities->sum('duration');

        // 4. ユーザーのアクティビティをグループに関連付け
        foreach ($reflectActivities as $activity) {
            $group->activities()->attach($activity->id);
        }

        $group->users()->attach(auth()->id(), ['role' => 'member', 'joined_at' => now()]);
        //usersのリレーションを呼び出し現在のユーザーを追加。その時に以下の情報を付与
        $group->save();

        return redirect()->route('groups.show', $group->id)->with('success', 'グループに加入しました。');
    }


    public function leave(Group $group)
    {
        $group->users()->detach(auth()->id());
        // ユーザーのアクティビティの合計時間をグループの合計勉強時間から減算
        $reflectActivities = auth()->user()->activities()->where('reflect', true)->get();
        //情報の取得を制限
        $totalUserStudyTime = $reflectActivities->sum('duration');

        foreach ($reflectActivities as $activity) {
            $group->activities()->detach($activity->id);  // アクティビティの関連付けを解除
        }
        $group->users()->detach(auth()->id()); //グループの関連を解除
        $group->save();

        return redirect()->route('groups.index')->with('success', 'グループを脱退しました。');
    }


    public function destroy(Group $group)
    {
        // ユーザーがグループのホストかどうかを確認
        $isHost = $group->users()->where('user_id', auth()->id())->wherePivot('role', 'host')->exists();
        if (!$isHost) //ホストではない場合
        {
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
        $data = $request->validate
            //バリデーション
            (
                [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('groups')->where(function ($query) use ($request) {
                            return $query->where('user_id', $request->user()->id);
                            //同じユーザーの同じ名前は不可
                        })
                    ],
                    'description' => 'nullable|string',
                ],
                [
                    // カスタムエラーメッセージ
                    'name.required' => 'カテゴリ名は必須です。',
                    'name.unique' => 'このカテゴリ名はすでに使用されています。'
                ]
            );
        // データを更新
        $group->update($data);

        return redirect()->route('groups.show', $group->id)->with('success', 'グループ情報を更新しました。');
    }

    public function show(Group $group)
    {
        $user_id = auth()->id();
        //IDを取得
        $members = $group->members()->get();
        //メンバー全員の情報を取得
        $member = $group->members()->where('user_id', $user_id)->first();
        //特定のユーザーの情報を取得
        $role = $member->pivot->role ?? null;
        //roleカラムの取得
        if ($role == 'host') {
            $currentUserRole = 'host';
        } elseif ($role == 'member') {
            $currentUserRole = 'member';
        } else {
            $currentUserRole = 'null';
        }

        return view('groups.show', compact('group', 'currentUserRole'));
    }

    public function showchart_week(Group $group)
    {
        // 過去1週間のアクティビティを取得
        $activities = Activity::whereHas('groups', function ($query) use ($group) //リレーション先のフィルタリング
        {
            $query->where('group_id', $group->id); //特定のグループ
        })
            ->where('reflect', true) //リフレクトのフィルタリング
            ->whereBetween('start_time', [Carbon::now()->subWeek(), Carbon::now()]) //今日から一週間前で取得
            ->get();

        // 日付ごとにアクティビティのグループを取得
        $groupedActivities = $activities->groupBy(function ($activity) {
            return $activity->start_time->format('Y-m-d');
        });

        // 過去7日間の全日付を生成
        $dates = collect(new \DatePeriod //過去7日の範囲を取得
            (
                Carbon::now()->subDays(6)->startOfDay(), //本日から6日前の日付を取得
                new \DateInterval('P1D'), //日付を一日単位で取得
                Carbon::now()->endOfDay() //一日の終わりを取得
            ))->mapWithKeys(function ($date) {
            return [$date->format('Y-m-d') => ['sum' => 0, 'average' => 0]]; //初期値0で計算
        });

        $studyData = $dates->merge($groupedActivities->mapWithKeys(function ($activities, $date)
        //日付とアクティビティを統合する。
        {
            $totalDuration = $activities->sum('duration');
            return
                [
                    $date =>
                    [
                        'sum' => $totalDuration,
                        'average' => $totalDuration / max($activities->count(), 1) //アクティビティの数で割る。
                    ]
                ];
        }));

        // ビューにデータを渡す
        return view(
            'groups.statistics',
            [
                'group' => $group, //グループ
                'studyData' => $studyData, //日付データ
                'labels' => $studyData->keys(), //日付のリスト
                'sumValues' => $studyData->pluck('sum'), //グラフ合計
                'averageValues' => $studyData->pluck('average') //グラフ平均
            ]
        );
    }

    public function showchart_month(Group $group)
    {
        // 過去1ヶ月間のアクティビティを取得
        $activities = Activity::whereHas('groups', function ($query) use ($group) {
            $query->where('group_id', $group->id);
        })
            ->where('reflect', true)
            ->whereBetween('start_time', [Carbon::now()->subMonth(), Carbon::now()])
            ->get();

        // 日付ごとにアクティビティを集計
        $groupedActivities = $activities->groupBy(function ($activity) {
            return $activity->start_time->format('Y-m-d');
        });

        // 過去30日間の全日付を生成
        $dates = collect(new \DatePeriod(
            Carbon::now()->subDays(29)->startOfDay(),
            new \DateInterval('P1D'),
            Carbon::now()->endOfDay()
        ))->mapWithKeys(function ($date) {
            return [$date->format('Y-m-d') => ['sum' => 0, 'average' => 0]];
        });

        // 日付ごとのデータを統合し、データがない日付には0を設定
        $studyData = $dates->merge($groupedActivities->mapWithKeys(function ($activities, $date) {
            $totalDuration = $activities->sum('duration');
            return
                [
                    $date =>
                    [
                        'sum' => $totalDuration,
                        'average' => $totalDuration / max($activities->count(), 1)
                    ]
                ];
        }));
        //ビュー渡す。
        return view(
            'groups.statistics_month',
            [
                'group' => $group,
                'studyData' => $studyData,
                'labels' => $studyData->keys(),
                'sumValues' => $studyData->pluck('sum'),
                'averageValues' => $studyData->pluck('average')
            ]
        );
    }
}
