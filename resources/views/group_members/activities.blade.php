<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}の勉強時間一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <div>
                    
 <a href="{{ route('user.activities.today', ['user' => $user->id]) }}">
    今日の勉強時間を見る
</a>

                </div>
                    <div>
     <a href="{{ route('user.activities.week', ['user' => $user->id]) }}">週間活動を表示</a>
     
     </div>
     
     <div> 
<a href="{{ route('user.activities.month', ['user' => $user->id]) }}">月間活動を表示</a>

 
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">勉強日</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">期間 (分)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activities as $activity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->studied_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->duration }}</td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('activities.show', $activity) }}" class="text-blue-500 hover:underline">詳細</a>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
