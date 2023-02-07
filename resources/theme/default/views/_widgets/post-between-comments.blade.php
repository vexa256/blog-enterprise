
<div class="row">
    <div class="{{ $post->pagination==null ? '' : '' }}" data-auto="true">
        <ul class="items_lists square">
            @foreach($lastFeatures as $item)
                @include('._particles._lists.items_list', ['listtype' => 'big_image titm bolb','descof' => 'off', 'setbadgeof' => 'off', 'metaof' => 'off', 'linkcolor' => 'default'])
            @endforeach
        </ul>
    </div>
</div>
