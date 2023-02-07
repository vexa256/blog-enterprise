 @if(get_buzzy_config('p_buzzycomment')=='on')
<script>
var CommentsVar = {
    ajax: "{{ route('comments') }}",
    requestData: {
        _token: "{{ csrf_token() }}",
        post_id: "{{ $post->id }}",
    },
    lang: {
        Success: "{{ trans('updates.success') }}",
        Error: "{{ trans('updates.error') }}",
        Ok: "{{ trans('updates.BuzzyEditor.lang.lang_15') }}",
        Cancel: "{{ trans('updates.BuzzyEditor.lang.lang_4') }}",
        Edit: "{{ trans('index.edit') }}",
        EditComment: "{{ __('Edit Comment') }}",
        Report: "{{ __('Report') }}",
        ReportComment: "{{ __('Report Comment') }}",
        ReportPlaceholder: "{{ __('Tell us why you are reporting this comment') }}",
        WriteSomething: "{{ trans('updates.BuzzyEditor.lang.lang_7') }}",
    },
    settings: {
        useUserTags: "{{ get_buzzy_config('COMMENTS_SHOW_USER_TAG') ? 1 : 0 }}",
    }
};
</script>
<script src="{{ asset('assets/js/comments.js?v='.config('buzzy.version')) }}"></script>
@endif
@if($post->type=="quiz")
<script>
    var BuzzyQuizzes = {
        lang_1: '{{ trans("buzzyquiz.shareonface") }}',
        lang_2: '{{ trans("buzzyquiz.shareontwitter") }}',
        lang_3: '{{ trans("buzzyquiz.shareface") }}',
        lang_4: '{{ trans("buzzyquiz.sharetweet") }}',
        lang_5: '{{ trans("buzzyquiz.sharedone") }}',
        lang_6: '{{ trans("buzzyquiz.sharedonedesc") }}',
    };
    Buzzy.Quizzes.init();
</script>
@endif
@if(get_buzzy_theme_config('PostPageAutoload', 'autoload') === 'autoload')
<script>
    if($(".news").length) {
        $(".news").buzzAutoLoad({
            item: ".news__item"
        });
    }
</script>
@endif
@if($has_video_player)
<script src="{{ asset('assets/plugins/video/video.min.js') }}"></script>
@endif
