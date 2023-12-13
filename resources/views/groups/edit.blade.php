<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- エラーメッセージ -->
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">エラー</strong>
                            <span class="block sm:inline">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </span>
                        </div>
                    @endif

                    <!-- グループ編集フォーム -->
                    <form action="{{ route('groups.update', $group->id) }}" method="POST" class="w-full max-w-lg">
                        @csrf
                        @method('PUT') <!-- HTTPメソッドをPUTに指定 -->

                        <!-- グループ名 -->
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label for="name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    グループ名:
                                </label>
                                <input type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" name="name" value="{{ $group->name }}" required>
                            </div>
                        </div>

                        <!-- グループの説明 -->
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label for="description" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    グループの説明:
                                </label>
                                <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="description" name="description" rows="3" required style="text-align: left;">{{$group->description }}</textarea>
                                <!---textareaは直接記述--->
                            </div>
                        </div>

                        <!-- 更新ボタン -->
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
</x-app-layout>
