@php($widgets = \App\Widgets::where('type', $position)->where('display', 'on')->get())
@if(count($widgets))
    <div class="clearfix"> </div>
    <div class="ads clearfix" >
        @foreach($widgets as $widget)
           <div class="{!! $widget->showweb == 'off' ? 'hide-web' : '' !!} {!! $widget->showmobile == 'off' ? 'hide-phone' : '' !!}">
                {!! $widget->text !!}
           </div>
        @endforeach
    </div>
    <div class="clearfix"> </div>
@endif
