<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            時間登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  
                <div class="card">
                    <h3 class="card-header mb-3">勉強時間登録
                    </h3>

                    <div class="card-body">
                        <form action="{{ route('activities.store') }}" method="POST" class="w-full max-w-lg">
                            @csrf

<!-- カテゴリ選択部分 -->
<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3">
  <label for="category_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
    カテゴリ</label>
    
  <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
  
  id="category_id" name="category_id"> <!--IDと名前をカテゴリに指定-->
  
    @foreach($categories as $category)
      <option value="{{ $category->id }}"><!--カテゴリIDを選択しに指定。-->
        {{ $category->name }}<!--名前を表示-->
        </option>
    @endforeach
  </select>
  </div>
  </div>
  



<div class="flex flex-wrap -mx-3 mb-3">
  <div class="w-full px-3">
  <label for="start_time" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
  勉強した日</label>
  
  <input type="datetime-local" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="start_time" name="start_time" required>
</div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3">
  <label for="duration" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
    勉強時間（分）</label>
    
  <input type="number" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="duration" name="duration" required>    
</div>
</div>


<div class="form-group mb-6 flex items-center">
  <input type="checkbox" class="mr-2" id="reflect" name="reflect" value="1" {{ old('reflect') ? 'checked' : '' }}>
  <label for="reflect">
  グループに反映する</label>
</div>
                                <input type="hidden" id="end_time" name="end_time">
  

<div>
<x-danger-button class="w-2/3">
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
