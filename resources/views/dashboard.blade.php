<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ホーム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("ようこそ！！") }}
                    
<div class="mb-4">
    <a href="{{ route('categories.create') }}" class="text-blue-500 hover:underline">カテゴリを追加</a>
    <p class="mt-1 text-gray-600">新しいカテゴリを追加します。</p>
</div>

<div class="mb-4">
    <a href="{{ route('activities.create') }}" class="text-blue-500 hover:underline">勉強時間の登録</a>
    <p class="mt-1 text-gray-600">今日の勉強時間を記録します。</p>
</div>

<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline">カテゴリ一覧</a>
    <p class="mt-1 text-gray-600">登録したカテゴリの一覧を表示します。</p>
</div>

<div class="mb-4">
    <a href="{{ route('activities.index') }}">勉強時間一覧</a>
    <p class="mt-1 text-gray-600">記録した勉強時間の一覧を確認します。</p>
</div>

<div class="mb-4">
    <a href="{{ route('activities.index_show') }}">勉強統計</a>
    <p class="mt-1 text-gray-600">勉強時間の統計を確認します。</p>
</div>

<div class="mb-4">
    <a href="{{ route('groups.dashboard') }}">グループ機能</a>
    <p class="mt-1 text-gray-600">グループ機能画面にアクセスします。</p>
</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
