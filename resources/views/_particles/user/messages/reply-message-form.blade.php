<h4>{{ trans('v4.add_new_message') }}</h4>
<div class="setting-form">
    {!! Form::open(['action' => ['UserMessageController@update', 'user' => $user->username_slug, 'id' =>$thread->id], 'method' =>
    'PUT', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {!! Form::textarea('message', old('message'), ['id' => 'message', 'placeholder' => trans('v4.message')]) !!}
    </div>
    <div>
        <input class="button button-orange button-full" type="submit" value="{{ trans('v4.send_reply') }}">
    </div>
    {!! Form::close() !!}
</div>
