<div class="entry" data-type="video" @if(isset($entry->id)) data-entry-id="{{ $entry->id }}" @endif>
    @include('editor._forms.__entryactions')
    <h3><i class="fa fa-youtube-play"></i> {{ trans('addpost.video') }}</h3>
    <div class="inpunting {{isset($entry->video) ? 'hidden' : ''}}">
        <div class="inpunting mediaupload {{isset($entry->image) ? 'hidden' : ''}}">
            @if(get_buzzy_config('EditorUserCanUploadVideol', 'yes') == 'yes')
            <div class="item-media-placeholder">
                <i class="fa fa-plus fa-2x"></i><br>
                <small class="text-muted">{{ __('Click to add a video.') }}</small>
                <form action="">
                    <input type="file" accept="video/mp4,video/webm" class="uploadavideo" data-target="video">
                </form>
                <div class="detail-or"> {{ trans('updates.or') }} </div>
                <div class="image-upload-actions">
                    <div class="getvideoinput">
                        {!! Form::text(null, null, ['class' => 'cd-input', 'placeholder' => trans('updates.urltovideo')]) !!}
                        <button class="button button-blue get-button create_embed" data-type="video">{{  trans('updates.get') }}
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                    <div class="note">
                        <i class="fa fa-info-circle"></i> {!! trans('addpost.videotips') !!}
                    </div>
                </div>
            </div>
            @else
            <div class="getvideoinput">
                {!! Form::text(null, null, ['class' => 'cd-input', 'placeholder' => trans('updates.urltovideo')]) !!}
                <button class="button button-blue get-button create_embed" data-type="video">{{  trans('updates.get') }}
                    <i class="fa fa-download"></i>
                </button>
            </div>
            <div class="note">
                <i class="fa fa-info-circle"></i> {!! trans('addpost.videotips') !!}
            </div>
            @endif
        </div>
    </div>

    <div class="embedarea @if(empty($entry->video)) hide @endif ">
        <div class="inpunting ordering">
            <button class="order-number button button-gray">1</button>
            {!! Form::text(null, isset($entry->title) ? $entry->title : null, ['data-type' => 'title', 'class' =>
            'cd-input ', 'placeholder' => trans('addpost.entry_titleop')]) !!}
        </div>
        {!! Form::hidden(null, isset($entry->video) ? $entry->video : null, ['data-type' => 'video', 'class' =>
        'cd-input cd-input-video']) !!}
        <div class="inpunting videoembed">
            @if(isset($entry->video))
            {!! parse_post_embed($entry->video, $entry->type) !!}
            @endif
        </div>

        <div class="moredetail text">
            <div class="detailhide hidden">
                <div class="inpunting">
                    {!! Form::textarea(null, isset($entry->body) ? $entry->body : null, ['data-type' => 'body', 'class' => 'cd-input message','id' => 'edit'.uniqid(), 'placeholder' => trans('addpost.entry_body')]) !!}
                </div>
            </div>
            <a href="javascript:;" class="trigger">
             <span class="down">{{ trans('addpost.mored') }} <i class="fa fa-angle-down"></i></span>
             <span class="up">{{ trans('addpost.lessd') }} <i class="fa fa-angle-up"></i></span>
            </a>
        </div>
    </div>
</div>
