@if(in_array($entry->type, ['video','tweet','facebookpost','embed','soundcloud', 'instagram']))
{!! parse_post_embed($entry->video, $entry->type) !!}
@endif
