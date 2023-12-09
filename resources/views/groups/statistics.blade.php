<x-app-layout>
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                　　
    <!--リンク集-->           　　

　　    <div class="flex justify-between mb-5">
    <a href="{{ route('groups.month', ['group' => $group->id]) }}">
        <x-serch-button>
    {{ $group->name }}の一か月の統計を見る
        </x-serch-button>
　　</a>
　　
    <a href="{{ route('groups.show', $group->id) }}">
        <x-danger-button>
        戻る
        </x-danger-button>
    </a>
　　
    </div>

<!--グラフ表示領域-->
    <div style="text-align: center;">
        <h2>{{ $group->name }}の今週の勉強時間グラフ</h2>
    </div>
    <div height ="600">
        <canvas id="weeklyStudyChart" width ="800" height ="600"></canvas>
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
                
                datasets: [

                {
                    label: '平均勉強時間 (分)',
                    data: studyTimes.map(o=>(o.average)),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },

                {
                    label: '合計勉強時間 (分)',
                    data: studyTimes.map(o=>(o.sum)),
   　　　　　  　　　　　 backgroundColor: 'rgba(255, 99, 132, 0.2)', // 控えめな赤色
   　　　　　  　　　　　　　　　　　　 borderColor: 'rgba(255, 99, 132, 1)',      // 控えめな赤色
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
    </div>
    </div>
    </div>
    </div>
</x-app-layout>
