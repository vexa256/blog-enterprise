<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.OptionalConfigurations') }}</div>
            <div class="panel-body no-padding">

<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
<li class="active"><a href="#general-setting" data-toggle="tab">{{__('General')}}</a></li>
<li><a href="#post-setting" data-toggle="tab">{{__('Post')}}</a></li>
<li><a href="#editor-setting" data-toggle="tab">{{__('Post Editor')}}</a></li>
<li><a href="#home-setting" data-toggle="tab">{{__('Home')}}</a></li>
<li><a href="#rss-setting" data-toggle="tab">{{__('RSS')}}</a></li>
</ul>
<div class="tab-content">

<div class="tab-pane active" id="general-setting">
    <div class="form-group">
        <label class="control-label">{{ __('Disable Registration?') }}</label>
        {!! Form::select('DisableRegister', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableRegister', 'no'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Disable Login Icon on Header?') }}</label>
        {!! Form::select('DisableLoginIcon', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableLoginIcon', 'no'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Disable Create Button on Header?') }}</label>
        {!! Form::select('DisableCreateButton', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableCreateButton', 'no'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Disable Search Icon on Header?') }}</label>
        {!! Form::select('DisableSearchIcon', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableSearchIcon', 'no'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Disable Viral Menu on Main Menu?') }}</label>
        {!! Form::select('DisableViralMenu', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableViralMenu', 'no'), ['class' => 'form-control']) !!}
        <span class="help-block">{{ __('Here you can disable the three dots dropdown menu') }}</span>
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Disable Language Picker?') }}</label>
        {!! Form::select('DisableLanguagePicker', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('DisableLanguagePicker', 'no'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="tab-pane" id="home-setting">
    <div class="form-group">
        <label class="control-label">{{ trans('admin.Auto-listedonHomepage') }}</label>
        {!! Form::select('AutoInHomepage', ['yes' => trans('admin.on'), 'no' => trans('admin.off')],
        get_buzzy_config('AutoInHomepage'), ['class' => 'form-control']) !!}
        <span class="help-block">{{ trans('admin.Auto-listedonHomepagehelp') }}</span>
    </div>
</div>

<div class="tab-pane" id="post-setting">
     <div class="form-group">
        <label>
            {{ trans('admin.SitePostsUrlType') }}
        </label>
        {!! Form::select('siteposturl', [
        '1' => 'yoursite.com/{category}/{slug} (Default)',
        '2' => 'yoursite.com/{category}/{id}',
        '3' => 'yoursite.com/{username}/{slug}',
        '4' => 'yoursite.com/{username}/{id}',
        '5' => 'yoursite.com/{category}/{slug}-{id}'
        ], get_buzzy_config('siteposturl'), ['class' => 'form-control']) !!}
        <span class="help-block">{{ trans('admin.SitePostsUrlTypehelp') }}</span>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label">{{ __('Show Categories on Post page?') }}</label>
        {!! Form::select('ShowCategories', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowCategories', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Show Badges on Post page?') }}</label>
        {!! Form::select('ShowBadges', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowBadges', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Show Featured Image on Post page?') }}</label>
        {!! Form::select('ShowFeaturedImage', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowFeaturedImage', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Show Share Icons on Post page?') }}</label>
        {!! Form::select('ShowShareIcons', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowShareIcons', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Show Font Sizer on Post page?') }}</label>
        {!! Form::select('ShowFontSizer', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowFontSizer', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label">{{ __('Show Author on Post page?') }}</label>
        {!! Form::select('ShowAuthor', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowAuthor', 'yes'), ['class' => 'form-control', 'data-dependecy' => 'ShowAuthor']) !!}
    </div>
    <div class="form-group" data-target="ShowAuthor" data-value="yes">
        <label class="control-label">{{ __('Show Author Badge on Post page?') }}</label>
        {!! Form::select('ShowAuthorBadge', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowAuthorBadge', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group" data-target="ShowAuthor" data-value="yes">
        <label class="control-label">{{ __('Show Publish Date on Post page?') }}</label>
        {!! Form::select('ShowPublishDate', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowPublishDate', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group" data-target="ShowAuthor" data-value="yes">
        <label class="control-label">{{ __('Show Updated Date on Post page?') }}</label>
        {!! Form::select('ShowUpdateDate', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowUpdateDate', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group" data-target="ShowAuthor" data-value="yes">
        <label class="control-label">{{ __('Show View Count on Post page?') }}</label>
        {!! Form::select('ShowViewCount', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowViewCount', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label">{{ __('Show Tags on Post page?') }}</label>
        {!! Form::select('ShowTags', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowTags', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Show Author Box on Post page?') }}</label>
        {!! Form::select('ShowAuthorBox', ['yes' => trans('admin.yes'), 'no' => trans('admin.no')],
        get_buzzy_config('ShowAuthorBox', 'yes'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="tab-pane" id="editor-setting">
    <div class="form-group">
        <label class="control-label">{{ __('Post Text Editor') }}</label>
        {!! Form::select('site_default_text_editor', [
        'tinymce' => __('TinyMCE Text Editor'),
        'froala' => __('Froala Text Editor'),
        'simditor' => __('Simditor Text Editor')],
        get_buzzy_config('site_default_text_editor', 'tinymce'), ['class' => 'form-control',
        'data-dependecy' => 'text_editor']) !!}
        <span
            class="help-block">{{ __('Here you can choose the text editor we use on the post create page.') }}</span>
    </div>
    <div class="form-group" data-target="text_editor" data-value="froala">
        <label class="control-label">{{ __('Froala Activation Key') }}</label>
        <input type="text" class="form-control input-lg" name="editor_froala_key"
            value="{{ get_buzzy_config( 'editor_froala_key' ) }}">
        <span class="help-block"><a href="https://froala.com/wysiwyg-editor/docs/activation/"
                target="_blank">@lang('v4.see_here_more_info')</a></span>
    </div>
    <div class="form-group">
        <label>
            {{ __('Filter Categories by Post Format') }}
        </label>
        {!! Form::select('EditorCategoriesFilter', [
        'yes' => trans('admin.yes'),
        'no' => trans('admin.no')
        ], get_buzzy_config('EditorCategoriesFilter', 'yes'), ['class' => 'form-control']) !!}
            <span class="help-block">{{ __('Disable this if you want use all categories for any post format.') }}</span>
    </div>
    <div class="form-group">
        <label>
            {{ __('Convert non-latin characters on post slug') }}
        </label>
        {!! Form::select('use_latin_slug', [
        'on' => trans('admin.yes'),
        'off' => trans('admin.no')
        ], get_buzzy_config('use_latin_slug', 'on'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label>
            {{ __('Users can select post language?') }}
        </label>
        {!! Form::select('EditorUserCanLanguage', [
        'yes' => trans('admin.yes'),
        'no' => trans('admin.no')
        ], get_buzzy_config('EditorUserCanLanguage', 'no'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label>
            {{ __('Users can select publish date?') }}
        </label>
        {!! Form::select('EditorUserCanPublishDate', [
        'yes' => trans('admin.yes'),
        'no' => trans('admin.no')
        ], get_buzzy_config('EditorUserCanPublishDate', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label>
            {{ __('Users can use Get From the URL option?') }}
        </label>
        {!! Form::select('EditorUserCanGetFromUrl', [
        'yes' => trans('admin.yes'),
        'no' => trans('admin.no')
        ], get_buzzy_config('EditorUserCanGetFromUrl', 'yes'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label>{{ __('Users can use upload video?') }}</label>
        {!! Form::select('EditorUserCanUploadVideol', [
        'yes' => trans('admin.yes'),
        'no' => trans('admin.no')
        ], get_buzzy_config('EditorUserCanUploadVideol', 'yes'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="tab-pane" id="rss-setting">
    <div class="form-group">
        <label class="control-label">{{ __('RSS Sitemap post limit') }} <a target="_blank" href="{{route('sitemap')}}"><i class="fa fa-link"></i></a></label>
        <input type="number" class="form-control input-lg" name="RSSSitemapPostLimit" value="{{ get_buzzy_config('RSSSitemapPostLimit', 500) }}">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('RSS Feed post limit') }} <a target="_blank" href="{{route('feed', ['type' => 'feed'])}}"><i class="fa fa-link"></i></a></label>
        <input type="number" class="form-control input-lg" name="RSSFeedPostLimit" value="{{ get_buzzy_config('RSSFeedPostLimit', 500) }}">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Google News post limit') }} <a target="_blank" href="{{route('feed', ['type' => 'googlenews'])}}"><i class="fa fa-link"></i></a></label>
        <input type="number" class="form-control input-lg" name="GoogleNewsPostLimit" value="{{ get_buzzy_config('GoogleNewsPostLimit', 500) }}">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Facebook Instant Article post limit') }} <a target="_blank" href="{{route('fbinstant')}}"><i class="fa fa-link"></i></a></label>
        <input type="number" class="form-control input-lg" name="FIAPostLimit" value="{{ get_buzzy_config('FIAPostLimit', 150) }}">
    </div>
</div>

</div>
</div>

            </div>
        </div>
    </div><!-- /.col -->

</div><!-- /.row -->
