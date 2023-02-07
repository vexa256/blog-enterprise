<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">{{ __('Comments Settings') }}</div>
            <div class="panel-body">

                <div class="form-group">
                    <label class="control-label">{{__('Comments area title')}}</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="COMMENTS_TITLE"
                            value="{{  get_buzzy_config('COMMENTS_TITLE') }}" placeholder="{{__('Comments')}}">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Comment must be manually approved')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USE_APPROVAL', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USE_APPROVAL', true),
                        ['data-dependecy' => 'COMMENTS_USE_APPROVAL', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group" data-target="COMMENTS_USE_APPROVAL" data-value="1">
                    <label class="control-label">{{__('Edited comment must be manually approved')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USE_EDIT_APPROVAL', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USE_EDIT_APPROVAL', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr>
                 <div class="form-group">
                    <label class="control-label">{{__('Allow Guest Comments')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_GUEST_COMMENT', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_GUEST_COMMENT', false),
                        ['data-dependecy' => 'COMMENTS_GUEST_COMMENT', 'class' => 'form-control']) !!}
                    </div>
                </div>

                  <div class="form-group" data-target="COMMENTS_GUEST_COMMENT" data-value="1">
                    <label class="control-label">{{__('Guest comment must be manually approved')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USE_GUEST_APPROVAL', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USE_GUEST_APPROVAL', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Allow Guest Comment Voting')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_GUEST_COMMENT_VOTING', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_GUEST_COMMENT_VOTING', false),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Limit the number of popular comments')}}</label>
                    <div class="controls">
                        <input type="number" class="form-control input-lg" name="COMMENTS_POPULAR_COUNT"
                            value="{{ get_buzzy_config('COMMENTS_POPULAR_COUNT', 3) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">{{__('Like vote count for popular comments')}}</label>
                    <div class="controls">
                        <input type="number" class="form-control input-lg" name="COMMENTS_POPULAR_LIKE_COUNT"
                            value="{{ get_buzzy_config('COMMENTS_POPULAR_LIKE_COUNT', 10) }}">
                        <p>{{__('If a comment gets # number of likes then show that comment in popular comments section')}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Limit the number of comments per page')}}</label>
                    <div class="controls">
                        <input type="number" class="form-control input-lg" name="COMMENTS_PAGE_COUNT"
                            value="{{ get_buzzy_config('COMMENTS_PAGE_COUNT', 15) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Comments maximum reply depth')}}</label>
                    <div class="controls">
                        <input type="number" class="form-control input-lg" name="COMMENTS_MAX_LEVEL"
                            value="{{  get_buzzy_config('COMMENTS_MAX_LEVEL', 3) }}">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Comments Default Order')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_DEFAULT_SORT',
                        ['new' => __('Newest'), 'old' => __('Oldest'), 'best'=> __('Best')],
                        get_buzzy_config('COMMENTS_DEFAULT_SORT', 'new'),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Replies Default Order')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_REPLIES_DEFAULT_SORT',
                        ['new' => __('Newest'), 'old' => __('Oldest'), 'best'=> __('Best')],
                        get_buzzy_config('COMMENTS_REPLIES_DEFAULT_SORT', 'old'),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('User can delete own comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USER_CAN_DELETE', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USER_CAN_DELETE', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('User can edit own comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USER_CAN_EDIT', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USER_CAN_EDIT', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('User can report a comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USER_CAN_REPORT', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USER_CAN_REPORT', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('User can add spoiler comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_USE_SPOILER_COMMENT', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_USE_SPOILER_COMMENT', false),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Email me when anyone posts a comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SEND_MAIL_ADDED', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SEND_MAIL_ADDED', false),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Email me when anyone posts a reply to comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SEND_MAIL_REPLY_ADDED', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SEND_MAIL_REPLY_ADDED', false),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Email me when a comment is held for approve?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SEND_MAIL_AWAIT_APPROVE', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SEND_MAIL_AWAIT_APPROVE', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Email user when comment is approved?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SEND_MAIL_APPROVED', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SEND_MAIL_APPROVED', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{__('Email user when comment is deleted?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SEND_MAIL_DELETED', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SEND_MAIL_DELETED', true),
                        ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Show user badge on comment?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SHOW_USER_BADGE', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SHOW_USER_BADGE', true),
                        ['class' => 'form-control']) !!}
                        <p>{{__('Admin, moderator and guest user badges on comments')}}</p>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{__('Use username tagging on reply?')}}</label>
                    <div class="controls">
                        {!! Form::select('COMMENTS_SHOW_USER_TAG', [true => trans("admin.yes"), false => trans("admin.no")],
                        get_buzzy_config('COMMENTS_SHOW_USER_TAG', true),
                        ['class' => 'form-control']) !!}
                        <p>{{__('On reply form, start with @username')}}</p>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.col -->

</div><!-- /.row -->
