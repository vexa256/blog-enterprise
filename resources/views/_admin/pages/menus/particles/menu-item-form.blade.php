<div class="box">
    {!! Form::open(array('action' => isset($menu_item->id) ? 'Admin\MenuItemController@update' :
    'Admin\MenuItemController@store', 'method' =>isset($menu_item->id) ? 'PUT' : 'POST')) !!}
    {{ csrf_field() }}
    <input type="hidden" name="menu_id" value="{{$menu->id}}">
    <input type="hidden" name="id" value="{{ isset($menu_item->id) ? $menu_item->id : null }}">
    <div class="box-body">
        <div class="form-group">
            <label for="add_menu_item_title" class="cs-label">{{trans('v4.menu_title')}} <span class="text-red">*</span></label>
            {!! Form::text('title', isset($menu_item->title) ? $menu_item->title : old('title'), ['id' =>
            'add_menu_item_title', 'class' => 'form-control input-field mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="add_menu_item_url" class="cs-label">{{trans('v4.menu_url')}}</label>
            {!! Form::text('url', isset($menu_item->url) ? $menu_item->url : old('url'), ['id' => 'add_menu_item_url',
            'class' => 'form-control input-field mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="add_menu_item_target" class="cs-label">{{trans('v4.open_in')}}</label>
            {!! Form::select('target', ['_self'=> trans('v4.same_tab'), '_blank'=>trans('v4.new_tab')],
            isset($menu_item->target) ? $menu_item->target : old('target') , ['class' => 'form-control input-field
            mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="add_menu_item_custom_class" class="cs-label">{{trans('v4.menu_icon')}}</label>
            {!! Form::text('icon', isset($menu_item->icon) ? $menu_item->icon : old('icon'), ['id' =>
            'add_menu_item_icon', 'class' => 'form-control input-field mb-2']) !!}
            Find your font code <a href="https://material.io/icons/" target="_blank">here.</a> Example
            code:<code>library_books</code><br>
        </div>
        <div class="form-group">
            <label for="add_menu_item_custom_class" class="cs-label">{{trans('v4.custom_class')}}</label>
            {!! Form::text('custom_class', isset($menu_item->custom_class) ? $menu_item->custom_class :
            old('custom_class'), ['id' => 'add_menu_item_custom_class', 'class' => 'form-control input-field mb-2']) !!}
        </div>
        @if(get_multilanguage_enabled())
        <div class="form-group">
            <label for="add_menu_item_custom_class" class="cs-label">{{trans('v4half.menu_language')}}</label>
            {!! Form::select('language', get_buzzy_language_list_options(), ! empty($menu_item->language) ?
            $menu_item->language : get_buzzy_locale() , [
            "id"=>"changeLanguage",
            'id' => 'add_menu_item_language', 'class' => 'form-control input-field mb-2']) !!}
        </div>
        @endif
        <div>

            <button type="submit"
                class="btn btn-{{isset($menu_item->id) ? 'success': 'primary'}} edit-info">{{isset($menu_item->id) ? trans('v4.update_menu_item'): trans('v4.add_menu_item')}}</button>
            @if(isset($menu_item->id))
            <a href="{{route('admin.menu.show', ['menu' => $menu->id])}}" class="btn btn-default pull-right">{{ trans('admin.Cancel') }}</a>

            @endif
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="box">
    <div class="box-body">
        {!! Form::open(array('action' => 'Admin\MenuItemController@storeFromCategory', 'method' => 'POST')) !!}
        <div class="form-group">
            {!! Form::label('parent_cat',trans('v4half.add_menu_for_category')) !!}
            {{ csrf_field() }}
            <input type="hidden" name="menu_id" value="{{$menu->id}}">
            <input type="hidden" name="language" value="{{get_buzzy_locale()}}">
            <select class="form-control" name="category_id">
                @foreach(\App\Category::byMain()->byLanguage(get_buzzy_locale())->get() as $alt_category)
                <optgroup>
                    <option value="{{ $alt_category->id }}">
                        {{ $alt_category->name }}
                    </option>
                    @foreach($alt_category->children()->orderBy('name')->get() as
                    $altalt_category)
                    <option value="{{ $altalt_category->id }}">
                        {{ $alt_category->name }} / {{ $altalt_category->name }}
                    </option>
                    @foreach($altalt_category->children()->orderBy('name')->get() as
                    $altaltalt_category)
                    <option value="{{ $altaltalt_category->id }}">
                        {{ $alt_category->name }} / {{ $altalt_category->name }} / {{ $altaltalt_category->name }}
                    </option>
                    @endforeach
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary edit-info">{{trans('v4.add_menu_item')}}</button>

        {!! Form::close() !!}
    </div>
</div>
