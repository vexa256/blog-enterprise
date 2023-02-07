@can('update', $post)
<div class="post_actions mt10">
    @if($post->approve == 'no')
    @can('approve', $post)
    <a href="{{ action('Admin\PostsController@bulkAction', ['ids' => $post->id, 'action' => 'approve']) }}" class="button button-orange button-small">
        <i class="material-icons">&#xE90A;</i>
        {{ trans('index.approve') }}
    </a>
    @else
    <a href="#" class="button button-orange button-small">
        <i class="material-icons">&#xE422;</i>
         {{ trans('index.waitapprove') }}
    </a>
    @endcan
    @endif
    @can('update', $post)
    <a href="{{ action('PostEditorController@showPostEdit', [$post->id]) }}" class="button button-green button-small">
        <i class="material-icons">&#xE150;</i>
        {{ trans('index.edit') }}
    </a>
    @endcan
    @can('delete', $post)
    <a href="{{ action('PostEditorController@deletePost', [$post->id]) }}" onclick="confim()" class="button button-red button-small">
        <i class="material-icons">&#xE16C;</i>
    </a>
    @endcan

    @if($publish_from_now)
    <div class="label label-admin">{{ trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')]) }}</div>
    @endif
</div>
@endcan
