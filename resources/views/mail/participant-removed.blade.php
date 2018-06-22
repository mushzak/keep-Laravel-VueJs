@component('mail::message')
# {{$participant->member->group->name}}
# You have been removed from our next meeting

Date and time:
{{\Carbon\Carbon::parse($participant->meeting->starts_at)->setTimezone('America/Chicago')->format('m/d/Y g:i a')}} Central

@component('mail::button', ['url' => route('groups.meetings.show', [$participant->member->group->slug, $participant->member->id])])
View the meeting
@endcomponent

@endcomponent

