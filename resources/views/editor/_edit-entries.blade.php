@foreach ($entries as $key => $entry)

@if ($entry->type == 'video')

@include('editor._forms.video', ['entry' => $entry])

@elseif($entry->type=='embed')

@include('editor._forms.embed', ['entry' => $entry])

@elseif($entry->type=='tweet')

@include('editor._forms.special', ['entry' => $entry ,
'typeofwidget' => 'tweet',
'titleofwidget' => trans('updates.tweet'),
'iconofwidget' => 'fa-twitter',
'urlto' => trans('updates.urltotweet'),
])
@elseif($entry->type=='facebookpost')

@include('editor._forms.special', ['entry' => $entry ,
'typeofwidget' => 'facebookpost',
'titleofwidget' => trans('updates.facebookpost'),
'iconofwidget' => 'fa-facebook',
'urlto' => trans('updates.urltofacebookpost'),

])

@elseif($entry->type=='instagram')

@include('editor._forms.special', ['entry' => $entry,
'typeofwidget' => 'instagram',
'titleofwidget' => trans('updates.instagram'),
'iconofwidget' => 'fa-instagram',
'urlto' => trans('updates.urltoinstagram'),
])

@elseif($entry->type=='soundcloud')

@include('editor._forms.special', ['entry' => $entry,
'typeofwidget' => 'soundcloud',
'titleofwidget' => trans('updates.soundcloud'),
'iconofwidget' => 'fa-soundcloud',
'urlto' => trans('updates.urltosoundcloud'),
])

@elseif($entry->type=='text')

@include('editor._forms.text', ['entry' => $entry])

@elseif($entry->type=='poll')

@include('editor._forms.poll.question', ['entry' => $entry])

@elseif($entry->type=='image')

@include('editor._forms.image', ['entry' => $entry])

@else

@include('editor._forms.text', ['entry' => $entry])

@endif

@endforeach
