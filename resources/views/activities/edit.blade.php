<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間編集
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('activities.update', $activity->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category_id">カテゴリ</label>
                <select class="form-control" id="category_id" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($activity->category->id == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="duration">時間 (分)</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ $activity->end_time->diffInMinutes($activity->start_time) }}">
            </div>

            <div class="mb-3">
                <label for="studied_at">日付</label>
                <input type="date" class="form-control" id="studied_at" name="studied_at" value="{{ $activity->studied_at->format('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label for="description">内容</label>
                <textarea class="form-control" id="description" name="description">{{ $activity->description }}</textarea>
            </div>
            
            <div class="form-group">
    　　　　　　　　<input type="checkbox" id="reflect" name="reflect" value="1" {{ $activity->reflect ? 'checked' : '' }}>
    　　　　　　　　<label for="reflect">グループに反映する</label>
　　　　　　</div>
　　　　　　<div>
　　　　　　    <button type="submit" class="btn btn-primary">更新</button>
　　　　　　</div>
        </form>
    </div>
</x-app-layout>
