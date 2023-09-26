<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            時間登録
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Record Activity</div>

                    <div class="card-body">
                        <form action="{{ route('activities.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="duration">Duration (in minutes)</label>
                                <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter duration in minutes" required>
                            </div>

                            <div class="form-group">
                                <label for="studied_at">Studied at</label>
                                <input type="datetime-local" class="form-control" id="studied_at" name="studied_at" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
