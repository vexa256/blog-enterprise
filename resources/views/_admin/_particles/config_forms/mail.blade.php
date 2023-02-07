<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                {{ trans('admin.MailSettings') }}
                <a href="https://support.akbilisim.com/docs/buzzy/mail-configuration" target="_blank" class="btn btn-sm btn-success pull-right -mt-5">
                    <i class="fa fa-eye"></i> @lang('v4.see_here_more_info')
                </a>
                <a href="{{route('admin.dashboard')}}/test-mail-config" data-toggle="tooltip"
                    data-original-title="{{trans('v4.send_test_email_info', ['email' => auth()->user()->email])}}" class="btn btn-sm btn-warning pull-right -mt-5 mr-10">
                    <i class="fa fa-eye"></i>
                    @lang('v4.send_test_email')
                </a><br>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label"> MAIL DRIVER</label>
                    <div class="controls">
                        {!! Form::select('MAIL_DRIVER', [
                        'smtp' => 'SMTP',
                        'ses' => 'Ses (Amazon Simple Email Service)',
                        'mailgun' => 'Mailgun',
                        'mail' => 'PHP Mail',
                        'sendmail' => 'SendMail',
                        'log' => __('Log (Email will be saved to error log)')
                        ],
                        env('MAIL_DRIVER', 'log'), ['data-dependecy' => 'mail_driver_input', 'class' => 'form-control'])
                        !!}
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="smtp">
                    <label class="control-label"> MAIL HOST</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" placeholder="smtp.gmail.com" name="MAIL_HOST"
                            value="{{  env('MAIL_HOST') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="smtp">
                    <label class="control-label"> MAIL PORT</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" placeholder="587" name="MAIL_PORT"
                            value="{{  env('MAIL_PORT') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="smtp">
                    <label class="control-label"> MAIL USERNAME</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="MAIL_USERNAME"
                            value="{{   auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('MAIL_USERNAME')  }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="smtp">
                    <label class="control-label"> MAIL PASSWORD</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="MAIL_PASSWORD"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('MAIL_PASSWORD')   }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="smtp">
                    <label class="control-label"> MAIL ENCRYPTION</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" placeholder="tls" name="MAIL_ENCRYPTION"
                            value="{{  env('MAIL_ENCRYPTION') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="ses">
                    <label class="control-label">SES ACCESS KEY ID</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="SES_ACCESS_KEY_ID"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" :  env('SES_ACCESS_KEY_ID') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="ses">
                    <label class="control-label">SES SECRET ACCESS KEY</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="SES_SECRET_ACCESS_KEY"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" :  env('SES_SECRET_ACCESS_KEY') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="ses">
                    <label class="control-label">SES DEFAULT REGION</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="SES_DEFAULT_REGION"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" :  env('SES_DEFAULT_REGION') }}">
                    </div>
                </div>

                <div class="form-group" data-target="mail_driver_input" data-value="mailgun">
                    <label class="control-label">MAILGUN DOMAIN</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="MAILGUN_DOMAIN"
                            value="{{  env('MAILGUN_DOMAIN') }}">
                    </div>
                </div>
                <div class="form-group" data-target="mail_driver_input" data-value="mailgun">
                    <label class="control-label">MAILGUN SECRET</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="MAILGUN_SECRET"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" :  env('MAILGUN_SECRET') }}">
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <label class="control-label">MAIL FROM NAME</label>
                    <input type="text" class="form-control input-lg" name="BuzzyContactName"
                        value="{{  get_buzzy_config('BuzzyContactName') }}"
                        placeholder="{{get_buzzy_config('sitename')}}">
                </div>
                <div class="form-group">
                    <label class="control-label">MAIL FROM ADDRESS</label>
                    <input type="text" class="form-control input-lg" name="BuzzyContactEmail"
                        value="{{  get_buzzy_config('BuzzyContactEmail') }}"
                        placeholder="{{get_buzzy_config('siteemail')}}">
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ __('Mail Template Logo Type?') }}</label>
                    {!! Form::select('MailTemplateLogoType', ['' => trans('admin.SiteName'), 'image' => __('Custom Logo'), 'custom' => __('Custom Title')],
                    get_buzzy_config('MailTemplateLogoType'), ['data-dependecy' => 'mail_logo', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group" data-target="mail_logo"  data-value="image">
                    <div class="row" >
                        <div class="col-xs-6">
                            <label for="maillogo">{{ __('Custom Logo') }}</label>
                            <input type="file" id="maillogo" name="maillogo">
                        </div>
                        <div class="col-xs-3">
                            <img class="field-image-preview img-thumbnail"
                                src="{{ asset(get_buzzy_config('maillogo', "/assets/images/logo.png")) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group"  data-target="mail_logo"  data-value="custom">
                    <label class="control-label">{{ __('Custom Title') }}</label>
                    <input type="text" class="form-control input-lg" name="MailTemplateCustomTitle"
                        value="{{  get_buzzy_config('MailTemplateCustomTitle') }}"
                        placeholder="{{get_buzzy_config('sitename')}}">
                </div>
            </div>
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
