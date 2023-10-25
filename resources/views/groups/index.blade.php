<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Groups
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul>
                        
@foreach($groups as $group)
    <li class="mb-4">
        <a href="{{ route('groups.show', $group->id) }}" class="text-blue-500 hover:underline">
            {{ $group->name }} (ID: {{ $group->id }}) - Role: {{ ucfirst($group->pivot_role) }}
        </a>
    </li>
@endforeach


                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
