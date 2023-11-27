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
                    <div class="card-header mb-3">勉強時間登録
                    </div>

                    <div class="card-body">
                        <form action="{{ route('activities.store') }}" method="POST">
                            @csrf
<!-- カテゴリ選択部分 -->
<div class="mb-6 sm:w-64 md:w-1/2 lg:w-1/3">
  <label for="category_id" class="block mb-2">カテゴリ</label>
  <select class="block appearance-none bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="category_id" name="category_id"> 
    @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
  </select>



<div class="form-group mb-3">
  <label for="start_time" class="block mb-2">勉強した日</label>
  <input type="datetime-local" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_time" name="start_time" required>
</div>

<div class="form-group mb-6 ">
  <label for="duration" class="block mb-2">勉強時間（分）</label>
  <input type="number" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="duration" name="duration" required>    
</div>

<div class="form-group mb-6 flex items-center">
  <input type="checkbox" class="mr-2" id="reflect" name="reflect" value="1" {{ old('reflect') ? 'checked' : '' }}>
  <label for="reflect">グループに反映する</label>
</div>
                                <input type="hidden" id="end_time" name="end_time">
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
