<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ詳細
        </h2>
    </x-slot>

    <div class="container">
        <h2>{{ $group->name }}</h2>
        <p>{{ $group->description }}</p>

        @if($currentUserRole == 'host')
        <div>
            <a href="{{ route('groups.members', $group->id) }}" class="btn btn-info">メンバー一覧を見る</a>
        </div>
        
            <p>あなたはこのグループのホストです。</p>
            

            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary">グループを編集</a>

            <form action="{{ route('groups.destroy', $group->id) }}" method="post" onsubmit="return confirm('本当にグループを削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">グループを削除</button>
            </form>

        @elseif($currentUserRole == 'member')
        <div>
            <a href="{{ route('groups.members', $group->id) }}" class="btn btn-info">メンバー一覧を見る</a>
        </div>
        
            <p>あなたはこのグループのメンバーです。</p>

            <form action="{{ route('groups.leave', $group->id) }}" method="post" onsubmit="return confirm('本当にこのグループを脱退しますか？');">
                @csrf
                <button type="submit" class="btn btn-warning">グループを脱退</button>
            </form>

        @else
            <form action="{{ route('groups.join', $group->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">このグループに加入</button>
            </form>
        @endif
    </div>
</x-app-layout>

