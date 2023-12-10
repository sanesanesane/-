<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('今週の勉強時間統計') }}
        </h2>
    </x-slot>

    <!-- グラフ表示領域 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <a href="{{ route('activities.showMonth') }}">
                            <x-serch-button class="py-2">
                                一か月
                            </x-serch-button>
                        </a>
                        <a href="{{ route('activities.index_show') }}">
                            <x-serch-button class="py-2">
                                日
                            </x-serch-button>
                        </a>
                    </div>
                    
                    <div>
                        <h2>今週の勉強時間グラフ</h2>
                        <canvas id="weeklyStudyChart" width="500" height="500"></canvas>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    
                    <script>
                        let rawData = @json($results);
                        let studyDates = [];
                        let studyTimes = [];
                        const endDate = new Date();
                        
                        for (let i = 6; i >= 0; i--) 
                        {
                            let date = new Date();
                            date.setDate(endDate.getDate() - i);
                            let formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD 形式に変換
                            studyDates.push(formattedDate);
                            studyTimes.push(0); // 初期値として0をセット
                        }
                        // rawDataからデータを取得してstudyTimesに反映
                        rawData.forEach(function(record) {
                            let index = studyDates.indexOf(record.study_date);
                            if (index !== -1) {
                                studyTimes[index] = record.total_duration;
                            }
                        });

                        var ctx = document.getElementById('weeklyStudyChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line', // 折れ線グラフを指定
                            data: {
                                labels: studyDates, // X軸のラベル
                                datasets: [{
                                    label: '勉強時間 (分)',
                                    data: studyTimes, // Y軸のデータ
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: false
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true // Y軸の始点を0に設定
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
