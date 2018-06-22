@component('mail::message')
# {{$reply->author->group->name}}

You have a private reply:

{{ str_limit($reply->body,48,' ...') }}

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$reply->author->group->slug]), 'color' => 'green'])
Go To Comment
@endcomponent
@endcomponent
