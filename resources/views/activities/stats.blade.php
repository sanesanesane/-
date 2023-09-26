<!-- stats.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強統計
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Study Stats</div>
                    <div class="card-body">
                        <p>勉強日数: {{ $studyDays }}日</p>
                        <p>継続日数: {{ $continuousDays }}日</p>
                    </div>

<div>{!! $chart->render() !!}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
