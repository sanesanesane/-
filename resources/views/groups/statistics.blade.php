<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $group->name }} の詳細
        </h2>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach($stats as $period => $data)
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">{{ ucfirst($period) }} Statistics</h3>
                            <ul>
                                <li><strong>Total Study Time:</strong> {{ $data['total'] }} minutes</li>
                                <li><strong>Average Study Time:</strong> {{ $data['average'] }} minutes</li>
                                <li><strong>Median Study Time:</strong> {{ $data['median'] }} minutes</li>
                                <li><strong>Top Studying User:</strong> {{ $data['topUser']->name }}</li>
                            </ul>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
