<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{!! trans("admin.BuzzyContactPluginSettings") !!}</h4>
</div>


<div class="modal-body">
    <div class="form-group">
        <label class="control-label">{!! trans("admin.BuzzyContactName") !!}</label>
        <input type="text" class="form-control input-lg" name="BuzzyContactName"
            value="{{  get_buzzy_config('BuzzyContactName') }}">
        <p>{!! trans("admin.BuzzyContactNameDesc") !!}</p>
    </div>
    <div class="form-group">
        <label class="control-label">{!! trans("admin.BuzzyContactEmail") !!}</label>
        <input type="text" class="form-control input-lg" name="BuzzyContactEmail"
            value="{{  get_buzzy_config('BuzzyContactEmail') }}">
        <p>{!! trans("admin.BuzzyContactEmailDesc") !!}</p>
    </div>
    <div class="form-group">
        <label class="control-label">{!! trans("admin.EmailSignature") !!}</label>
        <textarea class="form-control input-lg"
            name="BuzzyContactSignature">{{  get_buzzy_config('BuzzyContactSignature') }}</textarea>
        <p>{!! trans("admin.EmailSignatureDesc") !!}</p>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label">{!! trans("admin.Sendacopytomyemail") !!}</label>
        <input type="text" class="form-control input-lg" name="BuzzyContactCopyEmail"
            value="{{  get_buzzy_config('BuzzyContactCopyEmail') }}">
        <p>{!! trans("admin.SendacopytomyemailDesc") !!}</p>
    </div>
    <div class="clearfix"></div>
</div>
