<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ機能
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- グループ作成 -->
                    <div class="mb-4">
                        <a href="{{ route('groups.create') }}">
                            <x-serch-button>
                                グループ作成
                            </x-serch-button>
                        </a>
                        <p class="mt-1 text-gray-600">新しいグループを作成します。</p>
                    </div>
                    
                    <!-- グループ一覧 -->
                    <div class="mb-4">
                        <a href="{{ route('groups.index') }}">
                            <x-serch-button>
                                グループ一覧
                            </x-serch-button>
                        </a>
                        <p class="mt-1 text-gray-600">参加中のグループ一覧を表示します。</p>
                    </div>
                    
                    <!-- グループ検索 -->
                    <div class="mb-4">
                        <a href="{{ route('groups.search') }}">
                            <x-serch-button>
                                グループ検索
                            </x-serch-button>
                        </a>
                        <p class="mt-1 text-gray-600">グループを検索します。</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
