<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ作成
        </h2>
    </x-slot>

    <div class="container">

        <!-- エラーメッセージの表示部分をここに追加 -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- エラーメッセージの表示部分の終わり -->

        <form action="{{ route('groups.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">グループ名:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">グループの説明:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">グループを作成</button>
        </form>
    </div>
</x-app-layout>

