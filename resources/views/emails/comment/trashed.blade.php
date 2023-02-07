@component('mail::message')
{{__('Hi :user_name, We have bad news!', ['user_name' => $comment->user->username])}}
<br>
{!!__('Your comment for :post_title has been deleted!', ['post_title' => '<b>'.$comment->post->title .'</b>'])!!}

@component('mail::panel')
{!! parse_comment_text($comment->comment) !!}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
