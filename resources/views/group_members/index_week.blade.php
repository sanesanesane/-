<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}の今週の勉強時間グラフ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
 
                    <div class="flex justify-between mb-5">
                        <h2>今週の勉強時間グラフ</h2>
                        <a href="{{ route('group.members.activities', ['group' => $group->id, 'user' => $user->id]) }}">
                                <x-edit-button>
                                    戻る
                                </x-edit-button>
                            </a>
                    </div>
                    
                        <canvas id="weeklyStudyChart"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const rawData = @json($results);
                        const studyDates = [];
                        const studyTimes = [];
                        const endDate = new Date();
                        const daysInWeek = 7;

                        // 過去7日間の日付を生成し、勉強時間を0で初期化
                        for (let i = daysInWeek - 1; i >= 0; i--) 
                        {
                            let date = new Date();
                            date.setDate(endDate.getDate() - i);
                            let formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD 形式に変換
                            studyDates.push(formattedDate);
                            studyTimes.push(0); // 初期値として0をセット
                        }

                        // rawDataからデータを取得してstudyTimesに反映
                        rawData.forEach(function(record) {
                            const index = studyDates.indexOf(record.study_date);
                            if (index !== -1) {
                                studyTimes[index] = record.total_duration;
                            }
                        });

                        const ctx = document.getElementById('weeklyStudyChart').getContext('2d');
                        const myChart = new Chart(ctx, 
                        {
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
                            options:
                            {
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
