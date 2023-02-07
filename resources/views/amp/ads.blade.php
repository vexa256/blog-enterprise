<div class="ad-place">
    @php($widgets = \App\Widgets::where('type', $position)->where('display', 'on')->get())
    @if(count($widgets))
    @foreach($widgets as $widget)
    {!! $widget->text !!}
    @endforeach
    @endif
</div>
