<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間一覧 & グラフ表示
        </h2>
    </x-slot>
<a href="{{ route('activities.showWeek') }}">週</a>

    <div class="container mt-5">
        <!-- 一覧テーブルの表示 -->
        <table class="table">
            <thead>
                <tr>
                    <th>カテゴリ</th>
                    <th>時間</th>
                    <th>日付</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->category->name }}</td>
                        <td>{{ $activity->end_time->diffInMinutes($activity->start_time) }}分</td>
                        <td>{{ $activity->studied_at }}</td>
                        <td>{{ $activity->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        
<!-- グラフ表示領域 -->
<div>
    <h2>勉強時間グラフ</h2>
    <canvas id="studyChart" width="500" height="500"></canvas>
</div>
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

</x-app-layout>
