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



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let rawData = @json($results); // コントローラーから渡されたデータを受け取る
    let studyDates = [];
    let studyTimes = [];

    // データが空でないことを確認
    if (rawData.length > 0) {
        // カテゴリ別にデータを集計
        rawData.forEach(function(record) {
            studyDates.push(record.study_date);
            studyTimes.push(record.total_duration);
        });
    } else {
        // データがない場合は、今日の日付を追加し、勉強時間は0とする
        let todayFormatted = new Date().toISOString().split('T')[0];
        studyDates.push(todayFormatted);
        studyTimes.push(0);
    }

    // カラーコード生成関数
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // データセットを作成
    let datasets = [{
        label: '今日の勉強時間',
        data: studyTimes,
        backgroundColor: getRandomColor(),
        borderColor: getRandomColor(),
        borderWidth: 1
    }];

    // Chart.jsを使ってグラフを描画
    var ctx = document.getElementById('studyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: studyDates,
            datasets: datasets
        },
        options: {
            scales: {
                y: {
                    stacked: true,
                    beginAtZero: true
                },
                x: {
                    stacked: true
                }
            }
        }
    });
</script>

</div>
</div>
</div>
</div>
