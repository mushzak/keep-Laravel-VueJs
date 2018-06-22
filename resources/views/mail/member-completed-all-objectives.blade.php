@component('mail::message')
# {{$member->group->name}}

@component('mail::panel')
{{$member->user->name}} completed ALL objectives.
@endcomponent

@component('mail::button', ['url' => route('groups.profiles.show', ['group'=>$member->group->slug, 'member'=>$member->id]), 'color' => 'green'])
Go To Profile
@endcomponent

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$member->group->slug]), 'color' => 'green'])
Go To Discussions
@endcomponent


@endcomponent