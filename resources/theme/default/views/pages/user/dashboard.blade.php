@extends("pages.user.userapp")
@section("usercontent")
    <div class="recent-activity">
    sdfd
        @if($lastPost->total() > 0)
            <ul class="items_lists res-lists pad-0 clearfix">
                @foreach($lastPost as $item)
                    @include('._particles._lists.items_list', ['item'=> $item, 'listtype' => 'b','descof' => 'on', 'setbadgeof' => 'off', 'linkcolor' => 'default'])
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
