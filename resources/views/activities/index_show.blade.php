<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間一覧 & グラフ表示
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- グラフ切り替えボタン -->
                    <div class="mb-4">
                        <a href="{{ route('activities.showWeek') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                            週
                        </a>
                        <a href="{{ route('activities.showMonth') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
        一か月
        </a>
                    </div>

                    <!-- 一覧テーブル -->
                    <div class="mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリ</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">日付</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">勉強時間</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">アクション</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->studied_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->duration }}分</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-right">
                                          <a href="{{ route('activities.show', $activity->id) }}" class="inline-flex mr-3">
                                           <x-danger-button>
                                             詳細
                                            </x-danger-button>
                                              </a>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- グラフ表示エリア -->
                    <div class="mb-6">
                        <canvas id="studyChart" width="500" height="500"></canvas>
                      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let raw_data = @json($activities);

    const today = new Date();
    let data = raw_data.filter(activity => {
        const activityDate = new Date(activity.studied_at);
        return activityDate.getDate() === today.getDate() &&
               activityDate.getMonth() === today.getMonth() &&
               activityDate.getFullYear() === today.getFullYear();
    });

    let labels = ["今日の勉強時間"];
    let datasets = [];
    let categories = {};
    let totalMinutes = 0;

    data.forEach(activity => {
        // カテゴリ別にデータを集計
        if(!categories[activity.category.name]) {
            categories[activity.category.name] = 0;
        }
        let minutes = new Date(activity.end_time) - new Date(activity.start_time);
        minutes = minutes / 1000 / 60;
        categories[activity.category.name] += minutes;

        // 総勉強時間の更新
        totalMinutes += minutes;
    });

    // カラーコード生成関数
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // カテゴリごとにデータセットを作成
    for(const category in categories) {
        datasets.push({
            label: category,
            data: [categories[category]],
            backgroundColor: getRandomColor()
        });
    }

    var ctx = document.getElementById('studyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            scales: {
                y: {
                    stacked: true,
                    min: 0,
                    max: totalMinutes + 40 // 総勉強時間＋40分
                },
                x: {
                    stacked: true,
                }
            }
        }
    });
</script>  
                    
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
