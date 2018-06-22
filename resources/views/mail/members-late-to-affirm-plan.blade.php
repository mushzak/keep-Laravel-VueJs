@component('mail::message')
# {{$group->name}}
# Members late to affirm plan

The following members have two days remaining and have not affirmed their plans, as defined within your group setting:

@foreach($members as $member)
* <a href="{{route('groups.profiles.show', ['group'=>$member->group->slug, 'member'=>$member->id])}}">{{ $member->user->name }}</a>
@endforeach

We have notified them of the issue.

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$member->group->slug,]), 'color' => 'green'])
Discussions
@endcomponent


@endcomponent