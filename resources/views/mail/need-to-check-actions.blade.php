@component('mail::message')
# {{$group->name}}
# You have actions that need to be completed.


{{--@foreach($member->flags as $flag)--}}
{{--* {{__("flags.{$flag->type}")}}--}}
{{--@endforeach--}}


@if($member->group->account->manager && $member->user->id==$member->group->account->manager->id)
@foreach ($member->group->account->flags()->activeOnly()->get() as $flag)
* {{__("flags.{$flag->type}")}}
@endforeach
@endif

@if($member->group->facilitator && $member->user->id==$member->group->facilitator->id)
@foreach ($member->group->flags()->activeOnly()->get() as $flag)
* {{__("flags.{$flag->type}")}}
@endforeach
@endif

@if ($member->flags()->activeOnly()->count())
@foreach ($member->flags()->activeOnly()->get() as $flag)
* {{__("flags.{$flag->type}")}}
@endforeach
@endif


@component('mail::button', ['url' => route('home'), 'color' => 'green'])
Action List
@endcomponent


@endcomponent
