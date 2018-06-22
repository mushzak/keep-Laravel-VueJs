@component('mail::message')
# {{$group->name}}
# List of members late to check in

The following members have not checked in within the last {{ $group->check_in_interval }} days, as defined within your group settings:

@foreach($members as $member)
* <a href="route('groups.profiles.show', ['group'=>$member->group->slug, 'member'=>$member->id])">{{ $member->user->name }}</a> 
@endforeach

We have notified them of the issue.

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$member->group->slug,]), 'color' => 'green'])
Discussions
@endcomponent


@endcomponent
