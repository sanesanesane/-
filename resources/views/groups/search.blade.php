<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ検索
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!--エラーが起きた場合の実行内容-->
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <!--エラーが起きたときのアラーム設定--->
                            <strong class="font-bold">エラー</strong>
                            <!---太字で表示--->
                             <span class="block sm:inline">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                             <!--エラーを全部確認--->
                            </span>
                        </div>
                    @endif
                    
                    <!-- グループ検索フォーム -->
                    <form action="{{ route('groups.searchresults') }}" method="get" class="w-full max-w-lg">
                        <div class="mb-6">
                            <label for="groupId"
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                グループID:
                            </label>
                            <input type="text"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="groupId" name="id" required>
                        </div>
                        <div>
                            <x-danger-button type="submit">
                                検索
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

