<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{{__('Reaction Settings')}}</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <label class="control-label">{{ trans('v3half.reactionvotecount') }}</label>
        <div class="controls">
            <input type="number" class="form-control input-lg" name="showreactioniconon"
                value="{{  get_buzzy_config('showreactioniconon', 100) }}">
        </div>
        <span class="help-block">{{ trans('v3half.reactionvotehelp') }}</span>
    </div>
     <div class="form-group">
        <label> {{ trans('admin.Usersregistration') }} </label>
        {!! Form::select('sitevoting', [ '0' => trans('admin.yes'), '1' => trans('admin.no') ], get_buzzy_config('sitevoting'), ['class' => 'form-control']) !!}
    </div>
</div>
