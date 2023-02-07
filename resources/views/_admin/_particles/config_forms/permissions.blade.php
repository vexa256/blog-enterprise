<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.UserPermissions') }}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscanpost') }}
                    </label>
                    {!! Form::select('UserCanPost', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserCanPost'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscandeleteownposts') }}
                    </label>
                    {!! Form::select('UserDeletePosts', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserDeletePosts'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscaneditownposts') }}
                    </label>
                    {!! Form::select('UserEditPosts', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserEditPosts'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscaneditownusernames') }}
                    </label>
                    {!! Form::select('UserEditUsername', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserEditUsername'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscaneditownemails') }}
                    </label>
                    {!! Form::select('UserEditEmail', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserEditEmail'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('admin.Userscanaddownsocialmediaaddresses') }}
                    </label>
                    {!! Form::select('UserAddSocial', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserAddSocial'), ['class' => 'form-control']) !!}
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.AutoApprovePosts') }}</label>
                    {!! Form::select('AutoApprove', ['yes' => trans('admin.on'),'no' => trans('admin.off')],
                    get_buzzy_config('AutoApprove'), ['class' => 'form-control']) !!}
                    <span class="help-block">{{ trans('admin.AutoApprovePostshelp') }}</span>
                </div>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.Auto-approveeditedposts') }}</label>
                    {!! Form::select('AutoEdited', ['yes' =>trans('admin.on'),'no' => trans('admin.off')],
                    get_buzzy_config('AutoEdited'), ['class' => 'form-control']) !!}
                    <span class="help-block">{{ trans('admin.Auto-approveeditedpostshelp') }}</span>
                </div>
                <div class="form-group">
                    <label> {{ trans('admin.Usersregistration') }} </label>
                    {!! Form::select('sitevoting', [ '0' => trans('admin.yes'), '1' => trans('admin.no') ], get_buzzy_config('sitevoting'), ['class' => 'form-control']) !!}
                </div>
                <hr>
                <div class="form-group">
                    <label>
                        {{ __('Users must verify their email address') }}
                    </label>
                    {!! Form::select('UserVerifyEmail', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserVerifyEmail', 'no'), ['data-dependecy' => 'UserVerifyEmail', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group" data-target="UserVerifyEmail" data-value="yes">
                    <label>
                        {{ __('Users must verify to create post') }}
                    </label>
                    {!! Form::select('UserPostingVerifyEmail', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserPostingVerifyEmail', 'yes'), ['class' => 'form-control']) !!}
                </div>
                 <div class="form-group" data-target="UserVerifyEmail" data-value="yes">
                    <label>
                        {{ __('Users must verify to comment') }}
                    </label>
                    {!! Form::select('UserCommentingVerifyEmail', ['yes' => trans('admin.yes'),'no' => trans('admin.no')],
                    get_buzzy_config('UserCommentingVerifyEmail', 'yes'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div><!-- /.col -->

</div><!-- /.row -->
