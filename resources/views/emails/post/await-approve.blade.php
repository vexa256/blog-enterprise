@component('mail::message')
{!!__('A new post :post_title is waiting for your approval.', ['post_title' => '<b>'.$post->title .'</b>'])!!}

@component('mail::button', ['url' => $post->post_link])
{{__('View post')}}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
