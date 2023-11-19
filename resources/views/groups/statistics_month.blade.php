<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
    
                    <div>
                    <h2>{{ $group->name }}の今月の勉強時間グラフ</h2>
                    </div>
                    <div heigt ="800">
                     <canvas id="monthlyStudyChart" width="800" height="600"></canvas>
                    </div>
 

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const studyData = @json($studyData);
        const studyDates = Object.keys(studyData);
        const studyTimes = Object.values(studyData);
         console.log(studyTimes)

        const ctx = document.getElementById('monthlyStudyChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: studyDates,
                datasets: [
                    {
                        label: '平均勉強時間 (分)',
                        data: studyTimes.map(o => o.average),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: '合計勉強時間 (分)',
                        data: studyTimes.map(o => o.sum),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: true,//改善点
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</x-app-layout>

