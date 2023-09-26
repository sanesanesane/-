@foreach ($activities as $activity)
    <p>{{ $activity->category_id }} - {{ $activity->duration }} minutes</p>
@endforeach
