<div class="row">

    <div class="col-sm-12 col-md-8 col-lg-6">

        <div class="panel panel-info">
            <div class="panel-heading">{{ trans('v4.recaptcha_settings') }}</div>
            <div class="panel-body">

                <div class="form-group">
                    <label>App ID</label>
                    <input type="text" class="form-control input-lg" name="reCaptchaKey"
                        value="{{  get_buzzy_config('reCaptchaKey') }}">
                </div>
                <div class="form-group">
                    <label>App SECRET</label>
                    <input type="text" class="form-control input-lg" name="reCaptchaSecret"
                        value="{{ auth()->user()->isDemoAdmin() ? trans("admin.youPERMISSION") : get_buzzy_config('reCaptchaSecret')  }}">
                </div>
                <div class="form-group">
                    <label>{!! trans("v3.Usecaptchaonlogin")
                        !!}</label>
                    {!! Form::select('BuzzyLoginCaptcha', ['on' => trans("admin.yes"), 'off' => trans("admin.no")],
                    get_buzzy_config('BuzzyLoginCaptcha'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>{!! trans("v3.Usecaptchaonregister")
                        !!}</label>
                    {!! Form::select('BuzzyRegisterCaptcha', ['on' => trans("admin.yes"), 'off' =>
                    trans("admin.no")], get_buzzy_config('BuzzyRegisterCaptcha'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>{!! trans("admin.Usecaptchaoncontactform")
                        !!}</label>
                    {!! Form::select('BuzzyContactCaptcha', ['on' => trans("admin.yes"), 'off' =>
                    trans("admin.no")], get_buzzy_config('BuzzyContactCaptcha'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

    </div><!-- /.col -->
</div><!-- /.row -->
