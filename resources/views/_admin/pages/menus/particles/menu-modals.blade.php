<div class="box">
    {!!  Form::open(array('action' => 'Admin\MenuController@store', 'method' => 'POST')) !!}
        <div class="modal-body">
            <div class="form-group">
                <label for="add_menu_title" class="control-label">{{ trans('v4.menu_name')}} <span class="text-red">*</span></label>
                <input type="text" name="name" id="add_menu_title"  class="form-control input-field mb-2">
            </div>
            <div class="form-group">
                <label for="add_menu_url" class="control-label">{{ trans('v4.menu_location')}}</label>
                {!! Form::select('location', array_keys(config('buzzy.menus')), '', ['id' => 'add_menu_location', 'class' => 'form-control input-field mb-2'])  !!}
            </div>
            <div class="form-group">
                <label for="add_menu_custom_class" class="control-label">{{ trans('v4.custom_class')}}</label>
                <input type="text" name="custom_class" id="add_menu_custom_class" class="form-control input-field">
            </div>

            <div class="box-footer mt-10">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('admin.close')}}</button>
                <button type="submit" id="add_menu_item_btn" class="btn btn-info edit-info">{{ trans('v4.menu_add')}}</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>
