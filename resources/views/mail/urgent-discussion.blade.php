@component('mail::message')
# {{$discussion->author->group->name}}

@component('mail::panel')
<b>This is an urgent message:</b>
@endcomponent

{{ str_limit($discussion->body,48,' ...') }}

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$discussion->author->group->slug]), 'color' => 'green'])
Go To Comment
@endcomponent

@endcomponent
