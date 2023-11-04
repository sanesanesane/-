<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カテゴリ追加
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card-body">
                        <!-- エラーメッセージの表示 -->
                        @if($errors->has('name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            
                            <div class="form-group">
                                
                            <label class="block text-gray-350 text-sm font-bold mb-5" for="name">カテゴリ名</label>
                            <input class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-350 leading-tight focus:outline-none focus:shadow-outline mb-5" id="name" name="name" placeholder="カテゴリ名" required>
                               
                            </div>
<div class="text-left"> 
    <x-danger-button>
        追加
    </x-danger-button>
</div>
　　　　　　　　　　　　　　</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
