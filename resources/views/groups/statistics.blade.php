<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $group->name }} の詳細
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $group->name }}</div>
                    <div class="card-body">
                        <p>総勉強時間: {{ $group->total_study_time }} 分</p>
                        <!-- 他の詳細情報もここに追加できます -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
