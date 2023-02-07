@extends("_admin.adminapp")
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('admin.Categories') }}
        @if(get_multilanguage_enabled())
        &nbsp;>&nbsp; {!! get_language_list(get_buzzy_locale()) !!}
        @endif
    </h1>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active">{{ trans('admin.Categories') }}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            @include('_admin.pages.categories.particles._form')
        </div><!-- /.col -->

        <div class="col-md-8">
            @foreach($categories as $ci => $_category)
            <div class="nav-tabs-custom category-list">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header">
                        <i class="fa fa-{{config('buzzy.post_types.' . $_category->type. '.icon')}}"></i>

                        <b>{{ $_category->name }}</b>
                        <span>(<a href="{{route('admin.posts',  ['type' => 'category', 'category_id' => $_category->id])}}">{{__(':count Posts', ['count' => \App\Post::byCategories(get_category_all_childids_recursively($_category))->byApproved()->byPublished()->count()])}}</a>)</span>

                        @if($_category->disabled === "1")
                        <span class="pull-right badge bg-red" data-toggle="tooltip"
                            data-original-title="Category Disabled">DISABLED</span>
                        @endif
                        @if(!array_key_exists($_category->type, get_post_types()))
                        <span class="pull-right badge bg-red" data-toggle="tooltip"
                            data-original-title="Post type: {{ $_category->type }} deactivated on Plugins. Users can't add {{ $_category->type }} post type">Not available</span>
                        @endif
                    </li>
                    <li class="pull-right header">
                        <a href="{{ route('admin.categories', ['edit' => $_category->id]) }}"
                            class="btn btn-sm btn-success" role="button"
                            data-toggle="tooltip" title="" data-original-title="{{ trans("admin.edit") }}"><i
                                class="fa fa-edit"></i>
                            {{ trans('admin.edit') }}</a>
                        <a class="btn btn-sm btn-danger permanently"
                            href="{{ route('admin.category.delete', ['category' => $_category->id]) }}" role="button" data-toggle="tooltip"
                            data-original-title="{{ trans("admin.delete") }}"><i class="fa fa-times"></i>
                            {{ trans('admin.delete') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_{{ $ci }}-1">
                        @include('_admin.pages.categories.particles._list', ['altcategories' => $_category])
                    </div><!-- /.tab-pane -->
                </div>
            </div>
            @endforeach
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
@endsection
@section("footer")
@endsection
