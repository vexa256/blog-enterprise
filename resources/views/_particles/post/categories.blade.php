@if ($categories && get_buzzy_config('ShowCategories') !== 'no')
<div class="item_category clearfix">
    @foreach ($categories as $item)
    <a href="{{route('category.show', ['catname' => $item->name_slug ])}}" class="seca">
        {{$item->name}}
    </a>
    @endforeach
</div>
@endif
