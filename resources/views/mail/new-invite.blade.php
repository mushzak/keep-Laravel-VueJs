@component('mail::message')
# {{ $invite->group->name }}

You have been invited to join {{ $invite->group->name }} by {{$invite->group->facilitator->name}}. To accept this invitation, please follow this link.

@component('mail::button', ['url' => route('invites.index', $invite->token), 'color' => 'green'])
Accept the invite
@endcomponent

@endcomponent