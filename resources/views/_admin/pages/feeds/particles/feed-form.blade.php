<div class="box">
    <div class="box-header with-border">
        @if(!isset($feed))
        <h3 class="box-title"><i class="fa fa-edit"></i>
            <b>{{ trans('v4half.add_new_feed') }} </b> </h3>
        @else
        <h3 class="box-title"><i class="fa fa-edit"></i>
            <b>{{ trans('admin.edit') }} : {{ $feed->title }}</b> </h3>
        @endif
        <div class="box-tools pull-right">
            <a href="https://support.akbilisim.com/docs/buzzy/feed-fetcher" target="_blank" class="btn btn-sm btn-success">
                <i class="fa fa-eye mr-5"></i> @lang('v4.see_here_more_info')</a>
        </div>
    </div>
    {!! Form::open(array('action' => isset($feed->id) ? 'Admin\FeedController@update' :
    'Admin\FeedController@store', 'method' =>isset($feed->id) ? 'PUT' : 'POST')) !!}
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ isset($feed->id) ? $feed->id : null }}">
    <div class="box-body">
        <div class="form-group">
            <label for="add_feed_url" class="cs-label">{{trans('v4half.feed_url')}}</label>
            {!! Form::text('url', isset($feed->url) ? $feed->url : old('url'), ['id' => 'add_feed_url',
            'class' => 'form-control input-field mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="add_feed_interval" class="cs-label">{{trans('v4half.feed_check_interval')}}</label>
            {!! Form::select('interval', [
            'hourly'=> trans('v4half.hourly'),
            'daily'=> trans('v4half.daily'),
            'weekly'=> trans('v4half.weekly'),
            'monthly'=> trans('v4half.monthly')
            ],
            isset($feed->interval) ? $feed->interval : old('interval') , ['class' => 'form-control input-field
            mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="add_feed_content_fetcher" class="cs-label">{{trans('v4half.feed_content_fetcher')}}</label>
            {!! Form::select('content_fetcher', [
            'custom'=> trans('v4half.custom_fetcher'),
            'feed'=> trans('v4half.use_content_from_feed'),
            ],
            isset($feed->content_fetcher) ? $feed->content_fetcher : old('content_fetcher') , ['class' => 'form-control
            input-field
            mb-2']) !!}
        </div>
        <div class="form-group">
            <label for="post_categories" class="cs-label">{{trans('v4half.feed_post_categories')}}</label>
            <select id="post_categories" class="demo-default  mb-2" name="post_categories[]" multiple
                placeholder="{{ trans('v4half.feed_post_categories') }}">
                @foreach (\App\Category::byMain()->byLanguage()
                ->byActive()
                ->byOrder()
                ->get()
                as $ci => $categorys)
                <optgroup label="">
                    <option value="{{ $categorys->id  }}"
                        {{ isset($feed->post_categories) && in_array($categorys->id, explode(',', $feed->post_categories)) ? 'selected' : '' }}>
                        {{ $categorys->name }}</option>
                    @foreach ($categorys->children()->byActive()
                    ->orderBy('name')
                    ->get()
                    as $i => $cat)
                    <option value="{{ $cat->id  }}"
                        {{ isset($feed->post_categories) && in_array($cat->id, explode(',', $feed->post_categories))  ? 'selected' : '' }}>
                        <b>{{ $categorys->name }}</b> / {{ $cat->name }}</option>
                    @foreach ($cat->children()->byActive()
                    ->orderBy('name')
                    ->get()
                    as $io => $catq)
                    <option value="{{ $catq->id }}"
                        {{ isset($feed->post_categories) && in_array($catq->id, explode(',', $feed->post_categories))  ? 'selected' : '' }}>
                        <strong>{{ $categorys->name }}</strong> / <b>{{ $cat->name }}</b> /
                        {{ $catq->name }}</option>
                    @endforeach
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="add_feed_post_users" class="cs-label">{{trans('v4half.feed_post_user')}}</label>
            {!! Form::text('post_user_id', null,
            ['class' => '','id' => 'add_feed_post_users', 'placeholder' => trans('v4half.feed_search_post_user')]) !!}
        </div>
        <div class="form-group">
            <label for="add_feed_post_users" class="cs-label">{{trans('v4half.feed_post_fetch_count')}}</label>
            {!! Form::number('post_fetch_count', isset($feed->post_fetch_count) ?
            $feed->post_fetch_count : 10,
            [ 'class' => 'form-control input-field mb-2','id' => 'add_feed_post_count']) !!}
        </div>
        @if(get_multilanguage_enabled())
        <div class="form-group">
            <label for="add_menu_item_custom_class" class="cs-label">{{trans('v4half.feed_language')}}</label>
            {!! Form::select('language', get_buzzy_language_list_options(), ! empty($feed->language) ?
            $feed->language : get_buzzy_locale() , [
            'id' => 'add_menu_item_language', 'class' => 'form-control input-field mb-2']) !!}
        </div>
        @endif
        <div class="form-group">
            <label for="add_menu_item_custom_class" class="cs-label">{{trans('v4half.feed_active')}}</label>
            {!! Form::select('active', [true => trans('admin.yes'), false=>trans('admin.no') ],
            isset($feed->active) ? (bool)$feed->active : true,
            [ 'class' => 'form-control input-field mb-2']) !!}
        </div>
        <div>
            <button type="submit"
                class="btn btn-{{isset($feed->id) ? 'success': 'primary'}} edit-info">{{isset($feed->id) ? trans('v4half.update_feed'): trans('v4half.add_feed')}}</button>
            @if(isset($feed->id))
            <a href="{{route('admin.feeds')}}" class="btn btn-default pull-right">{{ trans('admin.Cancel') }}</a>
            @endif
        </div>
    </div>
    {!! Form::close() !!}
</div>
