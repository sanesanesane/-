<x-app-layout>  <!-- アプリのコンポーネント-->
    <x-slot name="header">  <!-- スロット-->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">  <!--テキストのスタイルの定義 -->
            カテゴリ追加
        </h2>
    </x-slot>

    <div class="py-12">  <!--スロットとの縦を定義-->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  <!--横のスペースを定義-->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">  <!--背景を設定-->
            
                <div class="p-6 text-gray-900">  <!-- パディングとテキストを設定-->

                    <div class="card-body">  <!--カードのボディ -->
                        <!-- エラーメッセージの表示 -->
                        @if($errors->has('name'))  <!-- エラーチェックの開始 -->
                            <div class="alert alert-danger">  <!-- エラーメッセージのコンテナ -->
                                {{ $errors->first('name') }}   <!--エラーのうちのnameの最初の分を表示する。-->
                            </div>
                        @endif  

                        <form action="{{ route('categories.store') }}" method="POST">  <!--form　データ送信メソッド　postでデータ送信するよ-->
                            @csrf  <!-- 防御-->

                            
                            <div class="form-group mb-5 ">  <!-- 入力をグループ化-->
                                
                            <label class="block text-gray-350 text-sm font-bold mb-5" for="name">カテゴリ名</label>  <!-- 入力フォームにタイトル-->
                            <input class="appearance-none block w-1/2 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" name="name" placeholder="カテゴリ名" required>
                               <!-- 入力フォーム--> 
                               
                            </div>


<div class="text-left">   <!--左から書くよ-->
    <x-danger-button>  <!--ボタンのコンポーネント-->
        追加
    </x-danger-button>
</div>
　　　　　　　　　　　　　　</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>