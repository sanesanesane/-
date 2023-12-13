<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}の今月の勉強時間グラフ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between mb-5">
                        <h1>今月の勉強時間グラフ</h1>
                        <a href="{{ route('group.members.activities', ['group' => $group->id, 'user' => $user->id]) }}">
                            <x-edit-button>
                                戻る
                            </x-edit-button>
                        </a>
                    </div>
                    
                    <div>
                        <canvas id="monthlyStudyChart"></canvas>
                    </div>
                    
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const rawData = @json($results);
                        const studyDates = [];
                        const studyTimes = [];
                        const endDate = new Date();
                        const daysInMonth = new Date(endDate.getFullYear(), endDate.getMonth() + 1, 0).getDate();

                        // 全日にわたってラベルを生成し、勉強時間を0で初期化
                        for (let day = 1; day <= daysInMonth; day++) 
                        {
                            const date = `${endDate.getFullYear()}-${String(endDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                            studyDates.push(date);
                            studyTimes.push(0); // 初期値として0をセット
                        }
                        
                        // rawDataからデータを取得してstudyTimesに反映
                        rawData.forEach(record => 
                        {
                            const index = studyDates.indexOf(record.study_date);
                            if (index !== -1) {
                                studyTimes[index] = record.total_duration;
                            }
                        });

                        const ctx = document.getElementById('monthlyStudyChart').getContext('2d');
                        const myChart = new Chart(ctx, 
                        {
                            type: 'line',
                            data:
                            {
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
                            options: 
                            {
                                scales: {
                                    y: {
                                        beginAtZero: true
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