<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">{{ trans('admin.SocialMedia') }}</div>
            <div class="panel-body">
                @foreach (config('buzzy.social_links') as $provider => $item)
                <div class="form-group">
                    <label class="control-label">
                        <a target=_blank href="{{  get_buzzy_config( $provider.'page') }}" class="btn btn-social-icon">
                            <img width="38" src="{{ $item['icon'] }}" />
                        </a> {{ $item['name'] }}
                    </label>
                    <div class="controls">
                        <label>{{ trans('v4.social_button_url', ['provider'=>$item['name']])}}</label>
                        <input type="text" class="form-control input-lg" name="{{$provider }}page"
                            value="{{  get_buzzy_config( $provider.'page') }}">
                        <label>{{trans('v4.social_button_text')}}</label>
                        <input type="text" class="form-control input-lg" name="{{$provider }}page_btn_text"
                            value="{{  get_buzzy_config( $provider.'page_btn_text' ) }}"
                            placeholder="{{get_social_links_trans($item)}}">
                    </div>
                </div>
                <hr />
                @endforeach

            </div>
        </div>

    </div><!-- /.col -->

</div><!-- /.row -->
