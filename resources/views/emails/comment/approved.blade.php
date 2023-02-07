@component('mail::message')
{{__('Hi :user_name, We have great news!', ['user_name' => $comment->user->username])}}
<br>
{!!__('Your comment for :post_title has been approved!', ['post_title' => '<b>'.$comment->post->title .'</b>'])!!}

@component('mail::button', ['url' => generate_comment_url($comment)])
{{__('View comment')}}
@endcomponent

@component('mail::panel')
{!! parse_comment_text($comment->comment) !!}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
