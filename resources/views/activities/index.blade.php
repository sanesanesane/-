<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勉強時間一覧
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">勉強時間のリスト</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead
                                <tr>
                                    <th>カテゴリ</th>
                                    <th>開始時間</th>
                                    <th>終了時間</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                
                                <tr>
                                    <td>{{ $activity->category ? $activity->category->name : 'カテゴリなし' }}</td>

                                    <td>{{ $activity->start_time }}</td>
                                    <td>{{ $activity->end_time }}</td>
                                    <td>
                                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-primary btn-sm">編集</a>
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                        </form>
                        　　　　　　　　　　　　<a href="{{ route('activities.show', $activity->id) }}" class="btn btn-info">詳細</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
