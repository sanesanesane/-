<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間詳細
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="mb-3">
            <strong>カテゴリ:</strong> {{ $activity->category->name }}
        </div>
        <div class="mb-3">
            <strong>時間:</strong> {{ $activity->start_time }} から {{ $activity->end_time }}
        </div>
        <div class="mb-3">
            <strong>日付:</strong> {{ $activity->studied_at }}
        </div>
        <div class="mb-3">
            <strong>内容:</strong> {{ $activity->description ?? '未記入' }}
        </div>
        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-primary">編集</a>
        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
    </div>
</x-app-layout>
