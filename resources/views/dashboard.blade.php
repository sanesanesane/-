<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <!-- カテゴリ追加のリンク -->
                    <a href="{{ route('categories.create') }}" class="text-blue-500 hover:underline">カテゴリを追加</a>

                    <!-- アクティビティ記録のリンク -->
                    <a href="{{ route('activities.create') }}" class="btn btn-primary ml-3">勉強時間の登録</a>
                    
<!-- カテゴリ一覧へのリンク -->
<a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline ml-3">カテゴリ一覧</a>


<a href="{{ route('activities.index') }}">勉強時間一覧</a>

<a href="{{ route('activities.index_show') }}">勉強統計</a>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
