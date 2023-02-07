<div class="row">
    @foreach(\App\Category::byMain()->byLanguage()->byActive()->orderBy('order')->take(10)->get() as $k => $cat)
    @if( $k % 2 == 0 )
        <div class="clearfix"></div>
    @endif
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{!! $cat->icon !!} {{ trans('admin.recentlyadded') }}
                    <b>{{ $cat->name }}</b>
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @php($posts = \App\Post::byCategories(get_category_ids_recursively($cat->id))->byPublished()->byApproved()->take(5)->get())
                @if($posts)
                <ul class="products-list product-list-in-box">
                    @foreach( $posts as $item)
                   <li class="item">
                        <div class="product-img">
                            <img src="{{ makepreview($item->thumb, 's', 'posts') }}" width="auto">
                        </div>
                        <div class="product-info">
                            <a href="{{ $item->post_link }}" target="_blank" class="product-title">
                                {{ $item->title }}
                            </a>
                            <span class="product-description text-gray">
                            <i class="fa fa-user"></i>
                            @if( $item->user)
                            <a href="{{ $item->user->profile_link }}" target="_blank" class="text-gray mr-10">{{ $item->user->username }}</a>
                            @endif
                            <i class="fa fa-clock-o"></i> {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                {{ trans('admin.nothingtoseehere') }}
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="{{ route('admin.posts', ['type' => 'category', 'category_id' => $cat->id]) }}" class="uppercase">
                {{ trans('admin.viewall') }}
                </a>
            </div><!-- /.box-footer -->
        </div>
    </div>
    @endforeach
</div>
