@extends("pages.user.userapp")
@section("usercontent")
<h2>{{ trans('v4.create_new_message') }}</h2>
<div class="setting-form">
    {!! Form::open(array('action' => array('UserMessageController@store', $user->username_slug), 'method' => 'POST',
    'enctype' => 'multipart/form-data')) !!}
    <div class="form-group">
        {!! Form::label('recipients', trans('v4.sent_to')) !!}
        {!! Form::text('recipients', old('recipients'), ['class' => '','id' => 'recipients', 'placeholder' =>
        trans('v4.sent_to')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('subject', trans('v4.subject')) !!}
        {!! Form::text('subject', old('subject'), ['class' => 'cd-input','id' => 'subject', 'placeholder' =>
        trans('v4.subject')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('message', trans('v4.message')) !!}
        {!! Form::textarea('message', old('message'), ['id' => 'message', 'placeholder' => trans('v4.message')]) !!}
    </div>

    <div class="clear"></div>

    <div>
        <input class="button button-orange button-full" type="submit" value="{{ trans('v4.send_message') }}">
    </div>
    <br><br>
    {!! Form::close() !!}
</div>

@endsection
@section("footer")
<script src="{{ asset('assets/js/selectize/selectize.min.js') }}"></script>
<script>
var BuzzyMessages = {
    url: '{{action("SearchController@searchUsers")}}',
    to_user: @if($to_user) { id: '{{$to_user->id}}', username: '{{$to_user->username}}' } @else false @endif
}
</script>
<script src="{{ asset('assets/js/buzzy-messages.js') }}"></script>
@endsection
