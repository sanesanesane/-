<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Study Time Graph') }}
        </h2>
    </x-slot>

 <!-- グラフ表示領域 -->
<div>
    <h2>今週の勉強時間グラフ</h2>
    <canvas id="weeklyStudyChart" width="500" height="500"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let raw_data = @json($activities);

    const today = new Date();
    const oneWeekAgo = new Date(today);
    oneWeekAgo.setDate(today.getDate() - 7);

    let filteredData = raw_data.filter(activity => {
        const activityDate = new Date(activity.studied_at);
        return activityDate >= oneWeekAgo && activityDate <= today;
    });

    let dailyTotals = {};
    let dates = [];

    // Initialize dailyTotals for the week
    for(let i = 6; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(today.getDate() - i);
        const dateString = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        dailyTotals[dateString] = 0;
        dates.push(dateString);
    }

    filteredData.forEach(activity => {
        let minutes = new Date(activity.end_time) - new Date(activity.start_time);
        minutes = minutes / 1000 / 60;
        const dateString = activity.studied_at.split(' ')[0];
        if(dailyTotals[dateString] !== undefined) {
            dailyTotals[dateString] += minutes;
        }
    });

    const studyTimes = dates.map(date => dailyTotals[date]);

    var ctx = document.getElementById('weeklyStudyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: '勉強時間 (分)',
                data: studyTimes,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</x-app-layout>
