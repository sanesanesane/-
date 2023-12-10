<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('カテゴリ一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-5">

                        <a href="{{ route('categories.create') }}">
                            <x-danger-button>
                                新しいカテゴリを追加
                            </x-danger-button>
                        </a>
                    </div>
                    @if (session('success'))
                        <!--コントローラーのサクセスがあるのか確認-->
                        <div class="alert alert-success">
                            {{ session('success') }} <!--コントローラーのサクセスを返します。-->
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200"> <!--テーブル-->
                        <thead><!--テーブルの目次-->
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    カテゴリ名</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    編集</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <!--繰り返し処理-->
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                        <!--テーブルの内容1-->
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <a href="{{ route('categories.edit', $category->id) }}">
                                            <!--カテゴリのIDを確認しそのIDの編集画面に飛ぶ-->
                                            <x-edit-button>
                                                編集
                                            </x-edit-button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- ページネーションリンク -->
                    <div>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
