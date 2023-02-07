@php($subcategories =$altcategories->children()->get())
@if(count($subcategories))
<table class="table table-striped">
    <tbody>
        <tr>
            <th>#</th>
            <th>{{ trans("admin.CatName") }}</th>
            <th>{{ trans("admin.Slug") }}</th>
            <th>{{ trans("admin.Createdat") }}</th>
            <th>{{ trans("admin.Actions") }}</th>
        </tr>
        @foreach($subcategories as $i => $cat)
        <tr>
            <td>{{ ceil($i+1) }}.</td>
            <td>{{ $cat->name }} <span>(<a href="{{route('admin.posts',  ['type' => 'category', 'category_id' => $cat->id])}}">{{__(':count Posts', ['count' => \App\Post::byCategories(get_category_all_childids_recursively($cat))->byApproved()->byPublished()->count()])}}</a>)</span></td>
            <td>{{ $cat->name_slug }}</td>
            <td>{{ $cat->created_at }}</td>
            <td>
                <a href="{{route('admin.categories', ['edit' => $cat->id])}}"
                    class="btn btn-sm btn-success" role="button" data-toggle="tooltip" title=""
                    data-original-title="{{ trans("admin.edit") }}"><i class="fa fa-edit"></i></a>
                <a class="btn btn-sm btn-danger permanently" href="{{ route('admin.category.delete', ['category' => $cat->id]) }}"
                    role="button" data-toggle="tooltip" data-original-title="{{ trans("admin.delete") }}">
                    <i class="fa fa-times"></i></a>
            </td>
        </tr>
        @foreach($cat->children()->get() as $io => $catq)
        <tr>
            <td></td>
            <td>{{ $catq->name }}</td>
            <td>{{ $catq->name_slug }}</td>
            <td>{{ $catq->created_at }}</td>
            <td>
                <a href="{{route('admin.categories', ['edit' => $catq->id])}}"
                    class="btn btn-sm btn-success" role="button" data-toggle="tooltip" title=""
                    data-original-title="{{ trans("admin.edit") }}"><i class="fa fa-edit"></i></a>
                <a class="btn btn-sm btn-danger permanently" href="{{ route('admin.category.delete', ['category' => $catq->id]) }}"
                    role="button" data-toggle="tooltip" data-original-title="{{ trans("admin.delete") }}"><i
                        class="fa fa-times"></i></a>
            </td>
        </tr>
        @endforeach

        @endforeach
    </tbody>
</table>
@endif
