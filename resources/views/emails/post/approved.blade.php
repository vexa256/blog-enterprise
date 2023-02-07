@component('mail::message')
{{__('Hi :user_name, We have great news!', ['user_name' => $post->user->username])}}
<br>
{!!__('Your post :post_title has been approved!', ['post_title' => '<b>'.$post->title .'</b>'])!!}

@component('mail::button', ['url' => $post->post_link])
{{__('View post')}}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
