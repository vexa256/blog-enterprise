<div class="row">

    <div class="col-sm-12  col-md-8 col-lg-6">

        <div class="panel panel-info">
            <div class="panel-heading">{{ trans('admin.LoginConfiguration') }}</div>
            <div class="panel-body form-horizontal">
                <legend><a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a> Facebook</legend>
                <div class="form-group">
                    <label for="facebookapp" class="col-sm-2 control-label">App ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="facebookapp" name="facebookapp"
                            value="{{ get_buzzy_config('facebookapp') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="facebookappsecret" class="col-sm-2 control-label">App SECRET</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="facebookappsecret" name="facebookappsecret"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('facebookappsecret')  }}">
                        <input type="hidden" name="facebook_login_callback"
                            value="{{  url('/auth/social/facebook/callback')  }}">
                    </div>
                </div>
                <br><br>
                <legend><a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a> Google</legend>
                <div class="form-group">
                    <label for="googleapp" class="col-sm-2 control-label">App ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="googleapp" name="googleapp"
                            value="{{  get_buzzy_config('googleapp') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="googleappsecret" class="col-sm-2 control-label">App SECRET</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="googleappsecret" name="googleappsecret"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('googleappsecret')  }}">
                        <input type="hidden" name="google_login_callback"
                            value="{{  url('/auth/social/google/callback')  }}">
                    </div>
                </div>
                <br><br>
                <legend><a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a> Twitter</legend>
                <div class="form-group">
                    <label for="twitterapp" class="col-sm-2 control-label">App ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="twitterapp" name="twitterapp"
                            value="{{  get_buzzy_config('twitterapp') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="twitterappsecret" class="col-sm-2 control-label">App SECRET</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="twitterappsecret" name="twitterappsecret"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('twitterappsecret')  }}">
                        <input type="hidden" name="twitter_login_callback"
                            value="{{  url('/auth/social/twitter/callback')  }}">
                    </div>
                </div>
                <br><br>
                <legend><a class="btn btn-social-icon btn-vk"><i class="fa fa-vk"></i></a> Vkontakte</legend>
                <div class="form-group">
                    <label for="VKONTAKTE_KEY" class="col-sm-2 control-label">App ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="VKONTAKTE_KEY" name="VKONTAKTE_KEY"
                            value="{{  get_buzzy_config('VKONTAKTE_KEY') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="VKONTAKTE_SECRET" class="col-sm-2 control-label">App SECRET</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="VKONTAKTE_SECRET" name="VKONTAKTE_SECRET"
                            value="{{  auth()->user()->isDemoAdmin() ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('VKONTAKTE_SECRET')  }}">
                        <input type="hidden" name="vkontakte_login_callback"
                            value="{{  url('/auth/social/vkontakte/callback')  }}">
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.col -->
</div><!-- /.row -->
