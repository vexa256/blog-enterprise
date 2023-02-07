<?php
$uniquid = isset($entry->uniquid) ? $entry->uniquid : time();
?>
<div class="entry" data-type="quizresult" data-co="{{ $uniquid }}" @if(isset($entry->id))
    data-entry-id="{{ $entry->id }}" @endif>
    <div class="entryactions">
        <button class="button button-red get-button delete-entry" data-block="entry"><i
                class="fa fa-trash"></i></button>
    </div>
    <h3><i class="fa fa-question-circle"></i> {{ trans('buzzyquiz.result') }}</h3>
    <div class="inpunting ordering">
        <button class="order-number button button-gray show">1</button>
        {!! Form::text(null, isset($entry->title) ? $entry->title : null, ['data-type' => 'title', 'class' => 'cd-input
        ', 'placeholder' => trans('buzzyquiz.result')]) !!}
    </div>
    <div class="moredetail text">
        <div class="inpunting">
            {!! Form::textarea(null, isset($entry->body) ? $entry->body : null, ['data-type' => 'body', 'class' =>
            'cd-input message','id' => 'edit'.uniqid(), 'placeholder' => trans('addpost.entry_body')]) !!}
        </div>
    </div>
    <div class="moredetail image">
        <div class="inpunting mediaupload {{isset($entry->image) ? 'hidden' : ''}}">
            <div class="item-media-placeholder">
                <i class="fa fa-picture-o  fa-2x"></i><br>
                <small class="text-muted">{{ trans('addpost.entry_addimage') }}</small>
                <form action="">
                    <input type="file" accept="image/*" class="uploadaimage" data-target="entry">
                </form>
                <div class="detail-or"> {{ trans('updates.or') }} </div>
                <div class="image-upload-actions">
                    <a class="button button-white getimageurl" data-action="add"
                        data-target="entry">{{ trans('updates.getfromurl') }} <i class="fa fa-download"></i></a>
                </div>
            </div>
        </div>

        {!! Form::hidden(null, isset($entry->image) ? makepreview($entry->image, null, 'entries') : null, ['data-type'
        => 'image', 'class' => 'cd-input cd-input-image ']) !!}
        <div class="inpunting imagearea @if(empty($entry->image)) hide @endif">
            <div class="imagearea_img">
                @if(isset($entry->image)) <img src="{{ makepreview($entry->image, null, 'entries') }}"> @endif
            </div>
            <div class="thumbactions">
                <a class="button button-red deleteimage" data-action="remove" data-target="image"><i class="fa fa-trash"></i></a>
                <a class="button button-white makepreview"><i class="fa fa-image"></i>&nbsp;{{ trans('addpost.makepreview') }}</a>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>
