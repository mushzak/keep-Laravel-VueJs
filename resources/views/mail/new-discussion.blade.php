@component('mail::message')
# {{$discussion->author->group->name}}

A new discussion was started:

<b>{{$discussion->title}}</b>

{{ str_limit($discussion->body,48,' ...') }}

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$discussion->author->group->slug]), 'color' => 'green'])
Go To Discussion
@endcomponent

@endcomponent
