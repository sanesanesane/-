<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カテゴリ編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    <div class="card-body">
                        <!-- エラーメッセージの表示 -->
                        @if ($errors->has('name'))
                            <!-- エラーチェックの開始 -->
                            <div class="alert alert-danger"> <!-- エラーメッセージのコンテナ -->
                                {{ $errors->first('name') }} <!--エラーのうちのnameの最初の分を表示する。-->
                            </div>
                        @endif

                        <!-- 更新用のフォーム -->
                        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PUT') <!-- ララベルのPUTメソッドを使用する。-->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-4">名前変更</label>
                                <input
                                    class="appearance-none block w-1/2 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="name" name="name" value="{{ $category->name }}" required>
                                <!--id と　name　を指定。　valueは元々のデータを反映-->
                            </div>
                            <div class="flex items-center space-x-4">
                                <x-danger-button>
                                    変更
                                </x-danger-button>
                        </form>
                        <!-- 削除用のフォーム -->
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                            onsubmit="return confirm('カテゴリを削除してもよろしいですか？');">
                            <!-- onsubmit="return confirm カテゴリを削除してもよろしいですかは削除の確認。-->
                        @csrf
                        @method('DELETE')
                         <x-secondary-button type="submit">
                             削除
                         </x-secondary-button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>