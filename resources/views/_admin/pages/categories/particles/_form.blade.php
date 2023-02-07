<div class="box ">
    <div class="nav-tabs-custom">
        @if(!isset($category->id))
        <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"
                    aria-expanded="true">{{ trans('admin.AddMainCategory') }}</a></li>
            <li class=""><a href="#glyphicons" data-toggle="tab"
                    aria-expanded="false">{{ trans('admin.AddSubCategory') }}</a></li>
        </ul>
        @else
        <ul class="nav nav-tabs pull-right">
            <li class="pull-left header"><i class="fa fa-edit"></i>
                <b>{{ trans('admin.edit') }} : {{ $category->name }}</b> </li>
        </ul>
        @endif
        <div class="tab-content">
            <!-- Font Awesome Icons -->
            <div class="tab-pane @if(isset($category->id)) @if($category->parent_id==null) active @endif @else active @endif"
                id="fa-icons">
                <!-- form start -->
                {!! Form::open(array('action' => array('Admin\CategoriesController@addnew'), 'method' => 'POST')) !!}
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ isset($category->id) ? $category->id : null }}">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.Categoryname')) !!}
                        {!! Form::text('name', isset($category->name) ? $category->name : null, ['id' => 'name', 'class'
                        => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryname') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name_slug',trans('admin.CategorySlug')) !!}
                        {!! Form::text('name_slug', isset($category->name_slug) ? $category->name_slug : null, ['id' =>
                        'name_slug', 'class' => 'form-control input-lg', 'placeholder' =>
                        trans('admin.Entercategoryslug') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('posturl_slug',trans('admin.PostUrlSlug')) !!}
                        {!! Form::text('posturl_slug', isset($category->posturl_slug) ? $category->posturl_slug : null,
                        ['id' => 'posturl_slug', 'class' => 'form-control input-lg', 'placeholder' =>
                        trans('admin.Enterpoststitleslug')]) !!}
                        <div class="help">{{ url("/") }}/<code>post_url_slug</code>/your-post-title</div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('type', 'Post Type') !!}
                        {!! Form::select('type', get_post_types(), isset($category->type) ? $category->type : null ,
                        ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description',trans('admin.CategoryDescription')) !!}
                        <textarea id="description" class="form-control" name="description" cols="50" rows="3"
                            spellcheck="false">{{ isset($category->description) ? $category->description : null }}</textarea>
                    </div>

                    @if(isset($category->id))
                    <div class="form-group">
                        {!! Form::label('disabled', trans('admin.disable')) !!}
                        {!! Form::select('disabled', ['0' => trans('admin.no'), '1' => trans('admin.yes')],
                        isset($category->disabled) ? $category->disabled : null , ['class' => 'form-control']) !!}
                    </div>
                    @endif
                    @if(get_multilanguage_enabled())
                    <div class="form-group">
                        <label for="add_menu_item_custom_class"
                            class="cs-label">{{trans('v4half.category_language')}}</label>
                        {!! Form::select('language', get_buzzy_language_list_options(), ! empty($category->language) ?
                        $category->language : get_buzzy_locale(), [
                        "id"=>"changeLanguage",
                        'id' => 'add_menu_item_language', 'class' => 'form-control input-field mb-2']) !!}
                    </div>
                    @endif
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"> {{ trans('admin.Submit') }}</button>
                    @if(isset($category->id))
                    <a href="{{route('admin.categories')}}" class="btn btn-default pull-right">Cancel</a>
                    @endif
                </div>
                {!! Form::close() !!}
            </div>

            <!-- glyphicons-->
            <div class="tab-pane @if(isset($category->id)) @if($category->parent_id!==null) active @endif @endif"
                id="glyphicons">
                <!-- form start -->
                {!! Form::open(array('action' => array('Admin\CategoriesController@addnew'), 'method' => 'POST')) !!}
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ isset($category->id) ? $category->id : null }}">
                    <input type="hidden" name="language"
                        value="{{ isset($category->language) ? $category->language : request()->get('lang') }}">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.Categoryname')) !!}
                        {!! Form::text('name', isset($category->name) ? $category->name : null, ['id' => 'name', 'class'
                        => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryname') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name_slug',trans('admin.CategorySlug')) !!}
                        {!! Form::text('name_slug', isset($category->name_slug) ? $category->name_slug : null, ['id' =>
                        'name_slug', 'class' => 'form-control input-lg', 'placeholder' =>
                        trans('admin.Entercategoryslug') ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description',trans('admin.CategoryDescription')) !!}
                        <textarea id="description" class="form-control" name="description" cols="50" rows="3"
                            spellcheck="false">{{ isset($category->description) ? $category->description : null }}</textarea>
                    </div>
                    <div class="form-group">
                        {!! Form::label('parent_cat',trans('admin.CategoryParent')) !!}
                        <select class="form-control" name="parent_id">
                            @foreach($categories as $alt_category)
                            <optgroup label="">
                                @if(!isset($category) || isset($category) && $category->id !== $alt_category->id)
                                <option value="{{ $alt_category->id }}"
                                    {{ isset($category->parent_id) && $category->parent_id ==$alt_category->id ? 'selected' : '' }}>
                                    {{ $alt_category->name }}</option>
                                @endif
                                @foreach($alt_category->children()->orderBy('name')->get() as
                                $altalt_category)
                                @if(!isset($category) || isset($category) && $category->id !== $altalt_category->id)
                                <option value="{{ $altalt_category->id }}"
                                    {{ isset($category->parent_id) && $category->parent_id ==$altalt_category->id ? 'selected' : '' }}>
                                    {{ $alt_category->name }} / {{ $altalt_category->name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"> {{ trans('admin.Submit') }}</button>
                    @if(isset($category->id))
                    <a href="{{route('admin.categories')}}" class="btn btn-default pull-right">{{ trans('admin.Cancel') }}</a>
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /#ion-icons -->

        </div>
        <!-- /.tab-content -->
    </div>



</div>
