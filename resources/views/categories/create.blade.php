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
                <div class="card">
                    <div class="card-header">新しいカテゴリ</div>

                    <div class="card-body">
                        <!-- エラーメッセージの表示 -->
                        @if($errors->has('name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <!-- カテゴリ名の入力フォーム -->
                            <div class="form-group">
                                <label for="name">カテゴリ名</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                            </div>

                            <button type="submit" class="btn btn-primary">追加</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
