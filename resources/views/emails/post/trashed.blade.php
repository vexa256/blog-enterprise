@component('mail::message')
{{__('Hi :user_name, We have bad news!', ['user_name' => $post->user->username])}}
<br>
{!!__('Your post :post_title has been deleted.', ['post_title' => '<b>'.$post->title .'</b>'])!!}

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
