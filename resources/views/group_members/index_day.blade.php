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
    let rawData = @json($results);
    let categories = {};
    let studyTimes = [];

    // カテゴリごとにデータを集計
    rawData.forEach(activity => {
        let category = activity.category.name; // カテゴリ名を取得
        if (!categories[category]) {
            categories[category] = 0; // 初期化
        }
        categories[category] += activity.total_duration; // 合計時間を加算
    });

    // データセットを作成
    for (let category in categories) {
        studyTimes.push({
            label: category,
            data: [categories[category]], // 各カテゴリの合計時間
            backgroundColor: getRandomColor() // それぞれ異なる色
        });
    }

    // グラフを描画
    var ctx = document.getElementById('studyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['今日の勉強時間'],
            datasets: studyTimes
        },
        options: {
            scales: {
                x: {
                    stacked: true // 縦積みオプション
                },
                y: {
                    stacked: true,
                    beginAtZero: true // Y軸の始点を0に設定
                }
            }
        }
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
</script>


</div>
</div>
</div>
</div>
