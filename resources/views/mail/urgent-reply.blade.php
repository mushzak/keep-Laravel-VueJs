@component('mail::message')
# {{$reply->author->group->name}}

@component('mail::panel')
<b>This is an urgent message:</b>
@endcomponent

{{ str_limit($reply->body,48,' ...') }}

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$reply->author->group->slug]), 'color' => 'green'])
Go To Comment
@endcomponent

@endcomponent