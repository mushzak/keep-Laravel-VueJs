@component('mail::message')
# {{$participant->member->group->name}}
# Please RSVP to our next meeting

Date and time:
{{\Carbon\Carbon::parse($participant->meeting->starts_at)->setTimezone('America/Chicago')->format('m/d/Y g:i a')}} Central

@component('mail::button', ['url' => route('participants.accept', $participant->id), 'color' => 'green'])
Accept the invite
@endcomponent

@component('mail::button', ['url' => route('participants.reject', $participant->id), 'color' => 'red'])
Reject the invite
@endcomponent


@endcomponent
