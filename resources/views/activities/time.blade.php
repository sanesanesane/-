<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            時間登録
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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

<div class="inline-block relative w-1/5 mb-6"> 
  <label for="category_id">カテゴリ</label>
  <select class="block appearance-none w-1/4 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="category_id" name="category_id"> 
    @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
  </select>
</div>


                            <div class="form-group mb-1">
                                <label for="start_time">勉強した日   </label>
                                <input type="datetime-local" class="shadow appearance-none border rounded py-2 px-3 text-gray-350 leading-tight focus:outline-none focus:shadow-outline mb-1" id="start_time" name="start_time" onchange="calculateEndTime()" required>
                            </div>

                            <div class="form-group mb-1">
                                <label for="duration">勉強時間（分） </label>
                                <input type="number" class="shadow appearance-none border rounded py-2 px-3 text-gray-350 leading-tight focus:outline-none focus:shadow-outline mb-1" id="duration" name="duration" onchange="calculateEndTime()" placeholder="勉強時間" required>
                            </div>
                            
                            <div class="form-group mb-6">
                            
                            <input class="mr-2 leading-tight"  type="checkbox" id="reflect" name="reflect" value="1" {{ old('reflect') ? 'checked' : '' }}>
                            
                            <label for="reflect">グループに反映する</label>
                            </div>


                            <input type="hidden" id="end_time" name="end_time">

                        <x-danger-button>
                            登録
                        </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
