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
                        <a href="{{ route('activities.showWeek') }}">
                            <x-serch-button class="py-2">
                                週
                            </x-serch-button>
                        </a>

                        <a href="{{ route('activities.showMonth') }}">
                            <x-serch-button class="py-2">
                                一か月
                            </x-serch-button>
                        </a>
                    </div>

                    <!-- 一覧テーブル -->
                    <div class="mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        カテゴリ</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        日付</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        勉強時間</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        アクション</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $activity->category ? $activity->category->name : 'カテゴリなし' }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $activity->start_time->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $activity->duration }}分</td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-right">
                                            <a href="{{ route('activities.show', $activity->id) }}"
                                                class="inline-flex mr-3">
                                                <x-danger-button>
                                                    詳細
                                                </x-danger-button>
                                            </a>
                                            <a href="{{ route('activities.edit', $activity->id) }}" class="inline-flex">
                                                <x-edit-button>
                                                    編集
                                                </x-edit-button>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>


                        <!-- グラフ表示エリア -->
                        <div class="mb-6">
                            <canvas id="studyChart" width="500" height="500"></canvas>
                            <!--キャンバス上、この上にchart.jsで記述する。-->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <!--chart.jsにライブラリを読み込み。-->
                            <script>
                                let raw_data = @json($activities);
                                //データをjsで使用出来るように
                                const today = new Date();
                                //日付を本日に設定。
                                let data = raw_data.filter(activity =>
                                    //フィルター通りに取得
                                    {
                                        const activityDate = new Date(activity.start_time);
                                        //日付の設定。newdateで(activity.start_time)を参照する。
                                        return activityDate.getDate() === today.getDate() &&
                                            activityDate.getMonth() === today.getMonth() &&
                                            activityDate.getFullYear() === today.getFullYear();
                                        //日付の一致を確認。
                                    });

                                let labels = ["今日の勉強時間"];
                                //ラベルの設定。
                                let datasets = [];
                                //データセットの設定
                                let categories = {};
                                //カテゴリデータの設定
                                let totalMinutes = 0;
                                //総合勉強時間の初期化

                                data.forEach(activity => {
                                    // カテゴリ別にデータを集計
                                    let category = activity.category ? activity.category.name : "カテゴリなし";
                                    if (!categories[activity.category.name]) {
                                        categories[activity.category.name] = 0;
                                    }
                                    //if分！（真　）｛偽　｝

                                    let minutes = activity.duration;
                                    //分数をactivityのdurationに設定


                                    categories[activity.category.name] += minutes;
                                    //勉強時間を設定

                                    // 総勉強時間の更新
                                    totalMinutes += minutes;
                                });


                                // カラーコード生成関数
                                function getRandomColor()
                                //ランダムに色を生成
                                {
                                    const letters = '0123456789ABCDEF';
                                    //文字セットを定義
                                    let color = '#';
                                    for (let i = 0; i < 6; i++)
                                    //色コードを設定
                                    {
                                        color += letters[Math.floor(Math.random() * 16)];
                                    }
                                    return color;
                                }

                                // カテゴリごとにデータセットを作成
                                for (const category in categories)
                                //for　ループカテゴリをループする。
                                //in  categoriesはカテゴリのプロパティをループする。
                                {
                                    //データセットを設定
                                    datasets.push({
                                        label: category,
                                        //ラベルをカテゴリに設定。
                                        data: [categories[category]],
                                        //データを割り当て
                                        backgroundColor: getRandomColor()
                                    });
                                }

                                var ctx = document.getElementById('studyChart').getContext('2d');
                                //canvasはを取得
                                var myChart = new Chart(ctx,
                                    //chartjsはグラフを取得
                                    {
                                        type: 'bar',
                                        //barグラフ
                                        data:
                                        //データを取得
                                        {
                                            labels: labels,
                                            datasets: datasets
                                        },

                                        options: {

                                            scales: {
                                                y: {
                                                    stacked: true, //真
                                                    min: 0,
                                                    max: totalMinutes + 20 // 総勉強時間＋20分
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
