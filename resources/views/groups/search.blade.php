<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ検索
        </h2>
    </x-slot>

    <div class="container">
        <form action="{{ route('groups.searchresults') }}" method="get">
            <div class="form-group">
                <label for="groupId">グループID:</label>
                <input type="text" class="form-control" id="groupId" name="groupId" required>
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
</x-app-layout>
