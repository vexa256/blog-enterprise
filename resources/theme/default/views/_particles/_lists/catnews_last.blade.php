@foreach($lastFeaturestop as $item)
    <a href="{{ $item->post_link }}">
        <img src="{{ makepreview($item->thumb, 'b', 'posts') }}">
        <h3>{{ $item->title }}</h3>
    </a>
@endforeach
