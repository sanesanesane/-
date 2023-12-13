<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function create() //カテゴリ作成ビュー
    {
        $categories = Category::all();  // カテゴリの一覧を取得
        return view('categories.create', compact('categories')); //カテゴリの情報を渡す
    }

    public function store(Request $request) //カテゴリ保存
    {
        $validatedData = $request->validate(
            [
                //カテゴリ保存ルール
                'name' =>
                [
                    'required', //絶対に入れる
                    'string', //文字列であるべき
                    'max:255', //255文字まで
                    Rule::unique('categories') //同じカテゴリを一つにする
                        ->where(function ($query) //クエリを参照
                        {
                            return $query->where('user_id', auth()->id())->whereNull('deleted_at');
                            //user idが現在ログインしているユーザーと一致している情報のみ→削除されているものは除外です。
                        }),
                ],
            ],

            [
                // カスタムエラーメッセージ
                'name.required' => 'カテゴリ名は必須です。', 'name.unique' => 'このカテゴリ名はすでに使用されています。',
            ]
        );
        $category = new Category; //新しいカテゴリ変数を作成
        $category->name = $request->name; //カテゴリの名前はリクエスト（入力）の名前
        $category->user_id = auth()->id(); //ログイン中ユーザーのIDに保存場所指定
        $category->save(); //保存
        return redirect()->route('categories.index')->with('success', '登録完了しました！'); //indexに文字とともに返す。
    }

    public function index()
    {
        $userId = auth()->id(); //useridをログイン中のユーザーに指定。
        $categories = Category::where('user_id', $userId)->get(); //ユーザーのカテゴリ情報を取得。
        $categories = Category::where('user_id', $userId)->paginate(5); //ペジネーション
        return view('categories.index', ['categories' => $categories]); //indexをカテゴリ情報と共に返す。
    }

    public function edit(Category $category) //カテゴリを参照し、データを送信
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // バリデーション
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id())
                            ->whereNull('deleted_at');
                    })],
        ], 
        [
            'name.required' => 'カテゴリ名は必須です。',
            'name.unique' => 'このカテゴリ名はすでに存在します。',
        ]);

        // バリデーションが成功したらカテゴリを更新
        $category->update($request->all()); //入力されたものをすべて取得
        
        return redirect()->route('categories.index')->with('success', 'カテゴリ変更完了しました！');
    }

    public function destroy(Category $category)
    {
        // 関連するデータがあるかチェック
        if ($category->activities()->exists()) {
            // 関連するデータがある場合、エラーメッセージと共にリダイレクト
            return redirect()->route('categories.index')->with('error', '関連するデータが存在するため削除できません！');
        }

        // 関連するデータがない場合、カテゴリを削除
        $category->delete();

        // 削除成功メッセージと共にリダイレクト
        return redirect()->route('categories.index')->with('success', 'カテゴリ削除しました！');
    }
}
