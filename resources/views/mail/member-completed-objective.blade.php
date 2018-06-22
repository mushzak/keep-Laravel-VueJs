@component('mail::message')
# {{$member->group->name}}

{{$member->user->name}} completed an objective:

{{$objective->name}}

@component('mail::button', ['url' => route('groups.profiles.show', ['group'=>$member->group->slug, 'member'=>$member->id]), 'color' => 'green'])
Go To Profile
@endcomponent

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$member->group->slug]), 'color' => 'green'])
Go To Discussions
@endcomponent

@endcomponent