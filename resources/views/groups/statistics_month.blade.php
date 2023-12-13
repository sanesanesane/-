<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!--リンク集-->
                    <div class="flex justify-between mb-5">
                        <a href="{{ route('groups.statistics', ['group' => $group->id]) }}">
                            <x-serch-button>
                                {{ $group->name }}の一週間の統計を見る
                            </x-serch-button>
                        </a>
                        <a href="{{ route('groups.show', $group->id) }}">
                            <x-danger-button>
                                戻る
                            </x-danger-button>
                        </a>
                    </div>

                    <div style="text-align: center;">
                        <!--水平方向に中央に記述-->
                        <h2>{{ $group->name }}の今月の勉強時間グラフ</h2>
                    </div>
                    <div height ="800">
                        <canvas id="monthlyStudyChart" width="800" height="600"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const studyData = @json($studyData);
                        const studyDates = Object.keys(studyData);
                        //studyDataの日付を取得
                        const studyTimes = Object.values(studyData);
                        //勉強時間を取得

                        const ctx = document.getElementById('monthlyStudyChart').getContext('2d');
                        //グラフを記述

                        const myChart = new Chart(ctx,
                            //グラフを描写
                            {
                                type: 'line',
                                //折れ線グラフ
                                data: {
                                    //データ
                                    labels: studyDates,
                                    //X軸の名前
                                    datasets:
                                        //データセット
                                        [{
                                                label: '平均勉強時間 (分)', //X軸
                                                data: studyTimes.map(o => o.average), //平均を取得し配列を生成
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)', //背景色
                                                borderColor: 'rgba(75, 192, 192, 1)', //線の色
                                                borderWidth: 1, //線の太さ
                                                fill: false
                                            },

                                            {

                                                label: '合計勉強時間 (分)',
                                                data: studyTimes.map(o => o.sum),
                                                backgroundColor: 'rgba(255, 99, 132, 0.2)', // 控えめな赤色
                                                borderColor: 'rgba(255, 99, 132, 1)', // 控えめな赤色
                                                borderWidth: 1,
                                                fill: false

                                            }
                                        ]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true, //最小0
                                            suggestedMax: true, //改善点
                                        }
                                    },
                                    responsive: true,
                                    maintainAspectRatio: false //バランスを保持
                                }
                            });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
