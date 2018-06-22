@component('mail::message')
# {{$member->group->name}}
# We have not heard from you in a while.


@if ($member->user->last_checked_in_at)
    I know that it's hard to believe, but it's been {{ $member->user->last_checked_in_at->diffForHumans() }} since you last visited {{ $member->group->name }}.
@else
    You need to check into your group, {{ $member->group->name }}, because you haven't done so yet.
@endif

@component('mail::button', ['url' => route('home'), 'color' => 'green'])
Check In
@endcomponent


@endcomponent
