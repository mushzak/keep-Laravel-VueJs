@component('mail::message')
# {{$discussion->author->group->name}}

You have a private discussion:

{{ str_limit($discussion->body,48,' ...') }}

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$discussion->author->group->slug]), 'color' => 'green'])
Go To Comment
@endcomponent
@endcomponent
