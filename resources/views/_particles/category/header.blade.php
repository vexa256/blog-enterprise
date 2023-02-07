<div class="headline-cats clearfix">
    <div class="global-container container">
        <div class="headline-cats-wrap {{count($category->children) > 10 ? 'full-width' : ''}}">
            <h1>{{ trans('index.'.$category->name_slug) == 'index.'.$category->name_slug ? $category->name : trans('index.'.$category->name_slug) }}
            </h1>
            @php ($subs = $category->children)
            <div class="cat-list">
                @if(count($subs) > 0)
                <a class="cat_link active" href="{{ route('category.show', ['catname' => $category->name_slug]) }}"> {{ trans('index.all') }}</a>
                @foreach($subs as $cat)
                <a class="cat_link" data-type="{{ $cat->name_slug }}" href="{{ route('category.show', ['catname' => $cat->name_slug]) }}">
                    {{ $cat->name }}</a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
