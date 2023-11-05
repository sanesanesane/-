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

                    <!-- グループ検索フォーム -->
                    <form action="{{ route('groups.searchresults') }}" method="get" class="w-full max-w-lg">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label for="groupId" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    グループID:
                                </label>
                                <input type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="groupId" name="id" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
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
