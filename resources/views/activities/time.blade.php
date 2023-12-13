<x-app-layout>
    <!-- ヘッダーセクション -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            時間登録
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- カードセクション -->
                    <div class="card">
                        <h3 class="card-header mb-3">勉強時間登録</h3>

                        <!-- フォーム部分 -->
                        <div class="card-body">
                            
                            <form action="{{ route('activities.store') }}" method="POST" class="w-full max-w-lg">
                                @csrf

                                <!-- カテゴリ選択部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <!--複数の要素を上からに配置-->
                                    <div class="w-full px-3">
                                        <!--x方向に幅-->
                                        <label for="category_id"
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            カテゴリ
                                        </label>
                                        <select
                                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="category_id" name="category_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    <!--選んだ選択肢を送信（｛｛PHPのデータを扱う時｝｝-->
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- 日付選択部分 -->
                                <div class="flex flex-wrap -mx-3 mb-3">
                                    <div class="w-full px-3">
                                        <label for="start_time"
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            勉強した日
                                        </label>
                                        <input type="datetime-local"
                                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="start_time" name="start_time" required>
                                    </div>
                                </div>
                                <!-- 時間選択部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="duration"
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            勉強時間（分）
                                        </label>
                                        <input type="number"
                                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="duration" name="duration" required>
                                    </div>
                                </div>
                                <!-- チェックボックス -->
                                <div class="form-group mb-6 flex items-center">
                                    <!--水平方法に配置-->
                                    <input type="checkbox" class="mr-2" id="reflect" name="reflect" value="1"
                                        {{ old('reflect') ? 'checked' : '' }}>
                                    <!--valueは送信する値-->
                                    <label for="reflect"
                                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold">
                                        グループに反映する
                                    </label>
                                    <input type="hidden" id="end_time" name="end_time">
                                    <!--非表示で送信-->
                                </div>
                                <!-- 送信ボタン -->
                                <div>
                                    <x-danger-button class="py-2">
                                        登録
                                    </x-danger-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
