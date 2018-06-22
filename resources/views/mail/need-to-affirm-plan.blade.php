@component('mail::message')
# {{$group->name}}
# Are you working your plan?

It's been more than {{$threshold}} days since you last updated or affirmed your plan. Those who remain mindful of a clear written plan enjoy an 80% higher success rate.

@component('mail::button', 
	['url' => route('groups.profiles.plan.edit',
		['group'=>$group->slug,
		'member'=>$member->id] ),
	 'color' => 'green'])
Go to Plan
@endcomponent



@endcomponent
