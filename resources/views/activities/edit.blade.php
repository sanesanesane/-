<x-app-layout>
    <!-- ヘッダーセクション -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間編集
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card">
                        <h3 class="card-header mb-3">勉強時間編集</h3>

                        <!-- フォームコンテナ -->
                        <div class="card-body">
                            <form action="{{ route('activities.update', $activity->id) }}" method="POST" class="w-full max-w-lg">
                                <!--大きさを画面幅に合わせて設定-->
                                @csrf
                                @method('PUT')

                                <!-- カテゴリ選択部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                <!--フレックスコンテナを使用。横軸を負の方向にずらす。--->
                                    <div class="w-full px-3">
                                        <label for="category_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        <!--文字の設定-->
                                            カテゴリ
                                        </label>
                                        <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="category_id" name="category_id">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($activity->category->id == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- 時間入力部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="duration" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            時間 (分)
                                        </label>
                                        <input type="number" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="duration" name="duration" value="{{ $activity->duration }}">
                                    </div>
                                </div>

                                <!-- 日付入力部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="start_time" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            勉強した日
                                        </label>
                                        <input type="date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="start_time" name="start_time" value="{{ $activity->start_time->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <!-- 内容入力部分 -->
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="description" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            内容
                                        </label>
                                        <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="description" name="description">{{ $activity->description }}</textarea>
                                    </div>
                                </div>

                                <!-- チェックボックス部分 -->
                                <div class="form-group mb-6 flex items-center">
                                <!---フォーム内容をまとめる--->
                                    <input type="checkbox" class="mr-2" id="reflect" name="reflect" value="1" {{ $activity->reflect ? 'checked' : '' }}>
                                    <label for="reflect" class="block uppercase tracking-wide text-gray-700 text-xs font-bold">
                                        グループに反映する
                                    </label>
                                </div>

                                <!-- 更新ボタン -->
                                <div>
                                    <x-danger-button type="submit">
                                        更新
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

