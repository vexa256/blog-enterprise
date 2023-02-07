<div class="category-input">
<select id="tagcats" class="demo-default" name="category" multiple placeholder="{{ trans('addpost.categories') }}">
    @php($_categories = isset($post) ? $post->categories()->get() : [])
    @foreach ($_categories as $_category)
       <option value="{{ $_category->id }}" selected>
            {{ $_category->name }}
        </option>
    @endforeach

    @foreach (\App\Category::byMain()->byLanguage(isset($post) ? $post->language : null)
        ->when(get_buzzy_config('EditorCategoriesFilter') !== 'no', function($q) use ($post_type){
            return $q->byType($post_type);
        })
        ->byActive()
        ->byOrder()
        ->get() as $category)
    <optgroup label="{{ $category->name }}">
        <option value="{{ $category->id }}">
            {{ $category->name }}
        </option>
        @foreach ($category->children()->byActive()->orderBy('name')->get() as $child_cat)
            <option value="{{ $child_cat->id }}" >
                <b>{{ $category->name }}</b> / {{ $child_cat->name }}
            </option>
            @foreach ($child_cat->children()->byActive()->orderBy('name')->get() as $child2_cat)
            <option value="{{ $child2_cat->id }}">
                <strong>{{ $category->name }}</strong> / <b>{{ $child_cat->name }}</b> / {{ $child2_cat->name }}
            </option>
            @endforeach
        @endforeach
    </optgroup>
    @endforeach
</select>
</div>
