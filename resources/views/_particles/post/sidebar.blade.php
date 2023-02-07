 <div class="sidebar hide-mobile">
    <div class="sidebar--fixed">
        @include('_particles.widget.ads', ['position' => 'PostPageSidebar', 'width' => '300', 'height' => 'auto'])

        @include('_particles.widget.trending', ['name'=> trans('index.posts')])

        @include('_particles.widget.follow')

        @include('_particles.widget.ads', ['position' => 'Footer', 'width' => '300', 'height' => 'auto'])
    </div>
</div>
