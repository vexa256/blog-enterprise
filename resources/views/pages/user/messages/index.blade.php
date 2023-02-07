@extends("pages.user.userapp")
@section('usercontent')
<div class="user_threads_header">
    <h2> {{ trans('v4.messages') }} ({{ auth()->user()->newThreadsCount() }})</h2>

    <a class="button button-blue button-small"
        href="{{ action('UserMessageController@create', ['user' => auth()->user()->username_slug]) }}" rel="nofollow">
        <i class="material-icons">send</i> {{ trans('v4.new_message') }}
    </a>
</div>
@if (count($threads))
<div class="user_threads_table_container">
    <table class="user_threads">
        <thead class="thread_header">
            <tr>
                <th class="thread-body-header">
                    {{ trans('v4.thread') }}
                </th>
                <th class="thread-message-count-header">
                </th>

                <th class="thread-date-header">
                    {{ trans('v4.last_activity') }}
                </th>

                <th class="thread-participents-header">
                    {{ trans('v4.participents') }}
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($threads as $thread)
                @include('_particles.user.messages.thread', ['thread' => $thread])
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('_particles.user.messages.no-threads')
@endif
<div class="thread-pagination">
    {!! $threads->links() !!}
</div>
@endsection
