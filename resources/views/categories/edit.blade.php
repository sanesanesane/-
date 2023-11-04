<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
            カテゴリ編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <!-- 更新用のフォーム -->
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-4">名前変更</label>
                        <input class="shadow appearance-none border rounded w-1/5 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ $category->name }}" required>
                    </div>

                    <div class="flex items-center space-x-4">
                        <x-danger-button>
                            変更
                        </x-danger-button>
                    </div>
                </form>

                <!-- 削除用のフォーム -->
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center space-x-4">
                        <x-secondary-button>
                            削除
                        </x-secondary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

