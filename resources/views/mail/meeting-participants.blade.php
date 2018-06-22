@component('mail::message')
# {{$meeting->group->name}}
# RSVP Status

Date and time:
{{\Carbon\Carbon::parse($meeting->starts_at)->setTimezone('America/Chicago')->format('m/d/Y g:i a')}} Central

This is the RSVP status with {{\Carbon\Carbon::parse($meeting->starts_at)->diffInDays(\Carbon\Carbon::now())}} days remaning till the meeting:

Attending:
@foreach($accepted as $participant)
* {{$participant->user->name}}
@endforeach

Not attending:
@foreach($declined as $participant)
* {{$participant->user->name}}
@endforeach

No response:
@foreach($no_response as $participant)
* {{$participant->user->name}}
@endforeach


@component('mail::button', ['url' => route('groups.meetings.show', [$meeting->group->slug, $meeting->id])])
View the meeting
@endcomponent

@component('mail::button', ['url' => route('groups.discussions.index',['group'=>$meeting->group->slug]), 'color' => 'green'])
Go To Discussion
@endcomponent


@endcomponent
