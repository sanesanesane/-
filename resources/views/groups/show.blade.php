<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ詳細
        </h2>
    </x-slot>

    <div class="container">
        <div>
            <h2>{{ $group->name }}</h2>
        </div>
        <div>
            <h2>{{ $group->description }}</h2>  
            
        </div>
        

        @if($currentUserRole == 'host')


            <div>
                <p>あなたはこのグループのホストです。</p>
                
            </div>
            
            <div>
                <a href="{{ route('groups.statistics', $group->id) }}">統計を見る</a>
            </div>
            
            <div>
             <a href="{{ route('group.members.index', $group) }}">メンバー一覧を表示</a>
            </div>
            
            <div>
                <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary">グループを編集</a>
            </div>

            <div>
                
            <form action="{{ route('groups.destroy', $group->id) }}" method="post" onsubmit="return confirm('本当にグループを削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">グループを削除</button>
            </form> 
                
            </div>


        @elseif($currentUserRole == 'member')

            <div>
            <p>あなたはこのグループのメンバーです。</p>
            </div>
            
            <div>
                <a href="{{ route('groups.statistics', $group->id) }}">統計を見る</a>
            </div>
            <div>
                
                <a href="{{ route('group.members.index', $group) }}">メンバー一覧を表示</a>
 
            </div>
            <div>
                <form action="{{ route('groups.leave', $group->id) }}" method="post" onsubmit="return confirm('本当にこのグループを脱退しますか？');">
                @csrf
                <button type="submit" class="btn btn-warning">グループを脱退</button>
            </form>
            </div>


        @else
        <div>
            <form action="{{ route('groups.join', $group->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">このグループに加入</button>
            </form>  
        @endif
        
    </div>
</x-app-layout>

