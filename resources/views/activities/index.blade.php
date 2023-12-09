<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- カテゴリによる絞り込み機能 -->
<div class="mb-6 col-span-2">
<!--縦2列のグリッド-->
    <div class="grid lg:grid-cols-1 md:grid-cols-2 sm:grid-cols-1 gap-4">
       
    
        <form method="GET" action="{{ route('activities.index') }}">
            
        <select name="category_id" class="col-span-3 appearance-none w-1/2 bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="">すべてのカテゴリ</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
            </select>
        
            <input type="hidden" name="sort" value="{{ request('sort', 'date_asc') }}">
            
            <x-serch-button type="submit" class="col-span-3 py-2">
              絞り込み
            </x-serch-button>
            </form>
            </div>
            </div>




                    <!-- 日付順に並べる機能 -->
                    <div class="mb-4">
                         <a href="{{ route('activities.index', ['sort' => 'date_desc'] + request()->except('sort')) }}" class="pr-1">
                            <x-serch-button class="py-2">
                                日付昇順
                            </x-serch-button>
                        </a>
                        <a href="{{ route('activities.index', ['sort' => 'date_asc'] + request()->except('sort')) }}" class="pr-1" >
                        <!---ソートをdate_ascに変更--->
                            <x-serch-button class="py-2">
                                日付降順
                            </x-serch-button>
                        </a>
                    </div>
                
                
                <table class="min-w-full divide-y divide-gray-200">
                <!---区切り線を表示--->
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">カテゴリ</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">日付</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">勉強時間</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">アクション</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ $activity->category ? $activity->category->name : 'カテゴリなし' }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ $activity->start_time->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ $activity->duration }}分</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-right">
                                <!--- whitespace-no-wrapで折り返しを禁止する。--->
                                    <a href="{{ route('activities.show', $activity->id) }}" class="inline-flex mr-3">
                                    <!---ほかの要素と横並びに表示する。-->
                                        <x-danger-button>
                                            詳細
                                        </x-danger-button>
                                    </a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="inline-flex">
                                        <x-edit-button>
                                            編集
                                        </x-edit-button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $activities->links() }}
                    <!---ペジネーション--->
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>