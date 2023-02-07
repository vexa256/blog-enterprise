<legend>{{ trans('addpost.addnew') }}</legend>
@if (!isset($post) && get_buzzy_config('EditorUserCanGetFromUrl') !== 'no')
<a class="button button-rosy button-big submit-button getcontenturl" data-action="add" data-target="content">
    <i class="fa fa-download"></i>{{ trans('updates.getfromurl') }}
</a>
@endif
<a class="button button-gray button-big submit-button entry_fetch" data-method="Get" data-target="entries"
    data-puttype="append" data-type="textform" href="{{ route('post.new-entry-form', ['addnew' => 'text']) }}">
    <i class="fa fa-file-text"></i>{{ trans('addpost.add', ['type' => trans('addpost.text')]) }}
</a>
<a class="button button-orange button-big submit-button entry_fetch" data-method="Get" data-target="entries"
    data-puttype="append" data-type="imageform" href="{{ route('post.new-entry-form', ['addnew' => 'image']) }}">
    <i class="fa fa-picture-o"></i>{{ trans('addpost.add', ['type' => trans('addpost.image')]) }}
</a>
<a class="button button-red button-big submit-button entry_fetch" data-method="Get" data-target="entries"
    data-puttype="append" data-type="videoform" href="{{ route('post.new-entry-form', ['addnew' => 'video']) }}">
    <i class="fa fa-youtube-play"></i>{{ trans('addpost.add', ['type' => trans('addpost.video')]) }}
</a>
<a class="button button-blue button-big submit-button entry_fetch" data-method="Get" data-target="entries"
    data-puttype="append" data-type="pollform" href="{{ route('post.new-entry-form', ['addnew' => 'poll']) }}">
    <i class="fa fa-check-circle-o"></i>{{ trans('addpost.add', ['type' => trans('addpost.option')]) }}
</a>
<a class="button button-black button-big submit-button moreentry" href="javascript:;">
    {{ trans('updates.more') }} <i class="fa fa-caret-down"></i>
</a>

<div class="moreentrywidget hide">
    <a class="button button-blue button-big submit-button entry_fetch" data-method="Get" data-target="entries"
        data-puttype="append" data-type="tweetform" href="{{ route('post.new-entry-form', ['addnew' => 'tweet']) }}">
        <i  class="fa fa-twitter"></i>{{ trans('addpost.add', ['type' => trans('updates.tweet')]) }}
    </a>

    <a class="button button-blue button-big submit-button entry_fetch" data-method="Get" data-target="entries"
        data-puttype="append" data-type="facebookpostform"
        href="{{ route('post.new-entry-form', ['addnew' => 'facebookpost']) }}">
        <i class="fa fa-facebook"></i>{{ trans('addpost.add', ['type' => trans('updates.facebookpost')]) }}
    </a>

    <a class="button button-instagram button-big submit-button entry_fetch" data-method="Get" data-target="entries"
        data-puttype="append" data-type="instagramform"
        href="{{ route('post.new-entry-form', ['addnew' => 'instagram']) }}">
        <i class="fa fa-instagram"></i>{{ trans('addpost.add', ['type' => trans('updates.instagram')]) }}
    </a>

    <a class="button button-soundcloud button-big  submit-button entry_fetch" data-method="Get" data-target="entries"
        data-puttype="append" data-type="soundcloudform"
        href="{{ route('post.new-entry-form', ['addnew' => 'soundcloud']) }}">
        <i class="fa fa-soundcloud"></i>{{ trans('addpost.add', ['type' => trans('updates.soundcloud')]) }}
    </a>

    <a class="button button-black button-big submit-button entry_fetch" data-method="Get" data-target="entries"
        data-puttype="append" data-type="embedform" href="{{ route('post.new-entry-form', ['addnew' => 'embed']) }}">
        <i class="fa fa-code"></i>{{ trans('addpost.add', ['type' => trans('addpost.embed')]) }}
    </a>
</div>
