@if(!empty($posts))
<ul class="items_lists res-lists">
    @foreach($posts as $item)
        @include('._particles._lists.items_list', ['listtype' => 'b','descof' => 'on', 'setbadgeof' => 'off', 'linkcolor' => 'default'])
    @endforeach
    @if($posts->nextPageUrl())
    <li>
        <a href="{{ $posts->nextPageUrl() }}" class="page-next btn-more"> {{ trans('updates.loadmore') }} </a>
    </li>
    @endif
</ul>
@endif
