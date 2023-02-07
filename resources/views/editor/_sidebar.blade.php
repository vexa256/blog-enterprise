<div class="sidebar visiblesidebar-onmobile">
    <div class="sidebar--fixed">
        <div class="question-post-side-bar-form">
            <div class="cd-form" id="previewwrapper">
                <legend>{{ trans('addpost.preview') }}</legend>
                <div class="thumbwrapper">
                    <div class="previewshow {{isset($post->thumb) ? 'show': ''}}">
                        <div class="imagepr_wrap">
                            @if (isset($post->thumb)) <img src="{{ makepreview($post->thumb, 's', 'posts') }}"> @endif
                        </div>
                        <div class="thumbactions">
                            <a class="button button-red deleteimage" data-action="remove" data-target="thumb"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="preview-placeholder {{isset($post->thumb) ? 'hidden': ''}}">
                        <i class="fa fa-plus fa-2x"></i><br>
                        <div class="text-muted">{{ trans('addpost.pickpreview') }}</div>
                        <form action="">
                            <input type="file" accept="image/*" class="uploadaimage preview" data-target="preview">
                        </form>
                        <div class="detail-or"> {{ trans('updates.or') }} </div>
                        <div class="image-upload-actions">
                            <a class="button button-white getimageurl" data-action="add"
                                data-target="preview">{{ trans('updates.getfromurl') }} <i
                                    class="fa fa-download"></i></a>
                        </div>
                    </div>
                    {!! Form::hidden('thumb', isset($post->thumb) ? makepreview($post->thumb, 'b', 'posts') : null,
                    ['id' => 'upwthumb']) !!}
                </div>
            </div>
            <div class="cd-form">
                <legend>{{ trans('updates.tags') }}</legend>
                <p class="cd-select icon">
                    {!! Form::text('tags', isset($tags) ? $tags : null,
                    ['class' => '', 'id' => 'tags', 'placeholder' => trans('updates.addatag')]) !!}
                </p>
            </div>
            @if(auth()->user()->isAdmin() || get_buzzy_config('EditorUserCanPublishDate') !== 'no')
            <div class="cd-form">
                <legend>{{ trans('v3.publish_date') }}</legend>
                <p class="cd-select icon">
                    <input type="text" id="published_at" class="cd-input" placeholder="{{ trans('v3.publish_immediately') }}" value="{{ isset($post->published_at) ? $post->published_at : null }}" autocomplete="off">
                </p>
            </div>
            @endif
            @if(get_multilanguage_enabled() && (auth()->user()->isAdmin() || get_buzzy_config('EditorUserCanLanguage') !== 'no'))
            <div class="cd-form">
                <legend>{{ trans('v4.post_language') }}</legend>
                <p class="cd-select icon">
                    {!! Form::select('language', get_buzzy_language_list_options(), isset($post->language) ? $post->language : app()->getLocale(), ['id'=> 'language', 'class' => 'form-control']) !!}
                </p>
            </div>
            @endif
            @unless($post_type == 'quiz' or $post_type == 'poll')
            <div class="cd-form">
                <legend>{{ trans('updates.pagination') }}</legend>
                <p class="cd-select icon">
                    {!! Form::select('pagination', ['0' => trans('updates.all'), '1' => '1', '2' => '2', '3' => '3', '4'
                    => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'],
                    isset($post->pagination) ? $post->pagination : null) !!}
                </p>
            </div>
            @endunless
            <div class="sidebar-actions">
                {!! Form::submit(isset($post->id) ? trans('addpost.savec') : trans('addpost.createp'), ['class' =>
                'button button-orange button-full submit-button PostAction', 'data-post-t' => 'post']) !!}
                {!! Form::submit(trans('updates.saveasdraft'), ['class' => 'button button-rosy button-full submit-button
                PostAction', 'data-post-t' => 'draft']) !!}
                @if (isset($post->id))
                <a href="{{ $post->post_link }}"
                    class="button button-gray button-full">{{ trans('addpost.cancel') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
