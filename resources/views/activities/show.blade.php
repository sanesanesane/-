<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


    <div class="container mt-5">
        <div class="mb-4">
            <strong>カテゴリ:</strong> {{ $activity->category ? $activity->category->name : 'カテゴリなし' }}
            <!--形式は 条件 ? 真の場合の値 : 偽の場合の値 です-->
        </div>
        <div class="mb-4">
            <strong>日付:</strong> {{ $activity->start_time->format('Y-m-d') }}
            <!--ー年ー月ー日で表示-->
        </div>
        <div class="mb-4">
            <strong>時間:</strong> {{ $activity->duration }}分
        </div>
        <div class="mb-6">
            <strong>内容:</strong> {{ $activity->description ?? '未記入' }}
        </div>
        @if(auth()->id() === $activity->user_id)
        
    <!--ログイン中のユーザーと登録ユーザーが同じの場合-->
    
<div class="flex space-x-10">
<!--水平に間隔10で記述-->
<div>
 <a href="{{ route('activities.edit', $activity->id) }}" >
     
<x-danger-button>
    編集
</x-danger-button>

</div>

<div>
    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('このデータを削除してもよろしいですか？');">
        @csrf
        @method('DELETE')
        <x-secondary-button type="submit">
            削除
        </x-secondary-button>
    </form>    
</div>

</div>
@endif

    </div>
</x-app-layout>
