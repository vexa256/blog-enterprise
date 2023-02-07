<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{{__('Multi-Language Settings')}}</h4>
</div>

<div class="modal-body">
     <div class="form-group">
        <label class="control-label">{{ __("Multi-Language Set Type") }}</label>
        {!! Form::select('multilanguage_type', [
            'route' => __('Route - Use route prefix to set language'),
            'cookie' => __('Cookie - Use cookies to store language'),
        ], get_buzzy_config('multilanguage_type', 'route'), ['class' => 'form-control']) !!}
    </div>
</div>
