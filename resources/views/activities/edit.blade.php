<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間編集
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

<div class="flex justify-center">
    
                   
                    
    <div class="container mt-5">
        <form action="{{ route('activities.update', $activity->id) }}" method="POST">
            @csrf
            @method('PUT')
            
<div class="inline-block relative w-1/3 mb-6"> 

  <label for="category_id">カテゴリ</label>
                <select class="block appearance-none w-1/3 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="category_id" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($activity->category->id == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <div>
                <label for="duration">時間 (分)</label>    
                </div>
                <div>
                <input type="number" class="shadow appearance-none border rounded py-2 px-3 text-gray-350 leading-tight focus:outline-none focus:shadow-outline w-1/5" id="duration" name="duration" value="{{ $activity->end_time->diffInMinutes($activity->start_time) }}">    
                </div>
                
            </div>

            <div class="mb-3">
                <div>
                <label for="studied_at">勉強日付</label>    
                </div>
                
                <div>
                <input type="date" class="shadow appearance-none border rounded py-2 px-3 text-gray-350 leading-tight focus:outline-none focus:shadow-outline w-1/5" id="studied_at" name="studied_at" value="{{ $activity->studied_at->format('Y-m-d') }}">    
                </div>
                
            </div>

            <div class="mb-5">
                <div>
                <label for="description">内容</label>    
                </div>
                <div>
                <textarea class="shadow appearance-none border rounded py-2 px-2 text-gray-350 leading-tight focus:outline-none focus:shadow-outline w-1/3 h-32" id="description" name="description">{{ $activity->description }}</textarea>
            </div>    
                </div>
               
<div class="form-group flex items-center mb-6">
    <input type="checkbox" class="mr-2" id="reflect" name="reflect" value="1" {{ $activity->reflect ? 'checked' : '' }}>
    <label for="reflect">グループに反映する</label>
</div>


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
