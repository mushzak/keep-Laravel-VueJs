@component('mail::message')
# {{$participant->member->group->name}}
# Meeting Reminder

This is a reminder of our next meeting. 
Date and time:
{{\Carbon\Carbon::parse($participant->meeting->starts_at)->setTimezone('America/Chicago')->format('m/d/Y g:i a')}} Central

Please be sure to update your Ask, Backstory, and Outcome before the meeting.

@component('mail::button', 
	['url' => route('groups.profiles.plan.edit',
		['group'=>$participant->member->group->slug,
		'member'=>$participant->member->id] ),
	 'color' => 'green'])
Go to Plan
@endcomponent


@endcomponent
