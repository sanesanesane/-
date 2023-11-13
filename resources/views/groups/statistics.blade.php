
<x-app-layout>
 <!-- グラフ表示領域 -->
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

    <div>
        <h2>{{ $group->name }}の今週の勉強時間グラフ</h2>
        <canvas id="weeklyStudyChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // PHPの配列をJavaScriptのオブジェクトに変換
        const studyData = @json($studyData);

        // 日付と勉強時間の配列を作成
        const studyDates = Object.keys(studyData);
        const studyTimes = Object.values(studyData);

        const ctx = document.getElementById('weeklyStudyChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: studyDates,
                datasets: [{
                    label: '勉強時間 (分)',
                    data: studyTimes,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                        suggestedMax: true //改善点
                     }   
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>
