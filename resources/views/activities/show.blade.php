<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Activity Detail
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Activity Details</div>
                    <div class="card-body">
                        <p><strong>ID:</strong> {{ $activity->id }}</p>
                        <p><strong>User ID:</strong> {{ $activity->user_id }}</p>
                        <p><strong>Category ID:</strong> {{ $activity->category_id }}</p>
                        <p><strong>Start Time:</strong> {{ $activity->start_time }}</p>
                        <p><strong>End Time:</strong> {{ $activity->end_time }}</p>
                        <p><strong>Duration:</strong> {{ $activity->duration }} minutes</p>
                        <p><strong>Studied At:</strong> {{ $activity->studied_at }}</p>
                        <p><strong>Created At:</strong> {{ $activity->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $activity->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
