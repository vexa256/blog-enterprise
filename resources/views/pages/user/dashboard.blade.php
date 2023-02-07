@extends("pages.user.userapp")
@section("usercontent")
    <div class="recent-activity">
        @if($lastPost->total() > 0)
            <ul class="items_lists res-lists pad-0 clearfix">
                @foreach($lastPost as $item)
                    @include('pages.catpostloadpage')
                @endforeach
            </ul>
            <div class="center-elements clearfix">
                {!! $lastPost->render() !!}
            </div>
            @else
            @include('errors.emptycontent')
        @endif
    </div>
@endsection
