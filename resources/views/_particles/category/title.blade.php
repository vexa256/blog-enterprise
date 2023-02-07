@if(isset($category->name))
    <div class="colheader rosy category-title">
        <h3 class="header-title">
            {{ trans('index.'.$category->name_slug) == 'index.'.$category->name_slug ? $category->name :  trans('index.'.$category->name_slug) }}
        </h3>
        <a target="_blank" class="rss-button right" href="{{ route('feed', ['type' => $category->name_slug]) }}">
            <i class="material-icons">&#xE0E5;</i>
        </a>
    </div>
@endif
