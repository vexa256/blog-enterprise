<div class="reaction-emojis">
    @php ($reactions = \App\ReactionIcon::byActive()->byLanguage()->orderBy('ord', 'asc')->get())
    @if (count($reactions) > 0)
    @foreach($reactions as $reaction)
    <a href="{{ route('reaction.show', ['reactionIcon' => $reaction->reaction_type]) }}" title="{{ $reaction->name }}">
        <img alt="{{ $reaction->name }}" src="{{ url($reaction->icon) }}" width="42" height="42">
    </a>
    @endforeach
    @endif
</div>
