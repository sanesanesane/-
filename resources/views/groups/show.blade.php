<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            グループ詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <strong>グループ名:</strong> {{ $group->name }}
                    </div>
                    <div class="mb-4">
                        <strong>説明:</strong> {{ $group->description }}
                    </div>
                    
                    <!-- アクションボタン -->
                    <div class="flex space-x-4 mt-5">
                        @if($currentUserRole == 'host')
                            <!-- ホストのアクション -->
<a href="{{ route('groups.statistics', $group->id) }}">
    <x-danger-button> 
    統計を見る
     </x-danger-button> 
</a>

<a href="{{ route('group.members.index', $group) }}" >
    <x-danger-button>
    メンバー一覧を表示
    </x-danger-button> 
</a>

<a href="{{ route('groups.edit', $group->id) }}" >
    <x-danger-button>
    グループを編集
    </x-danger-button>
</a>

<form action="{{ route('groups.destroy', $group->id) }}" method="post" onsubmit="return confirm('本当にグループを削除しますか？');">
    @csrf
    @method('DELETE')
    <x-secondary-button type="submit">
        グループを削除
    </x-secondary-button>
</form>

                        @elseif($currentUserRole == 'member')
                            <!-- メンバーのアクション -->
                            <x-danger-button onclick="location.href='{{ route('groups.statistics', $group->id) }}'">
                                統計を見る
                            </x-danger-button>
                            <x-danger-button onclick="location.href='{{ route('group.members.index', $group) }}'">
                                メンバー一覧を表示
                            </x-danger-button>
                            <form action="{{ route('groups.leave', $group->id) }}" method="post" onsubmit="return confirm('本当にこのグループを脱退しますか？');">
                                @csrf
                                <x-secondary-button type="submit">
                                    グループを脱退
                                </x-secondary-button>
                            </form>
                        @else
                            <!-- 非メンバーのアクション -->
                            <form action="{{ route('groups.join', $group->id) }}" method="post">
                                @csrf
                                <x-danger-button type="submit">
                                    このグループに加入
                                </x-danger-button>
                            </form>  
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
