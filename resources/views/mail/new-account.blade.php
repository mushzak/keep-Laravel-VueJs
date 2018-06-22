@component('mail::message')
# Welcome to {{env('APP_NAME')}}

{{env('APP_NAME')}} Group Facilitation Software makes it easy to start, run, and grow mastermind groups, peer advisory boards, and CEO roundtables.
Follow this link to get started.

@component('mail::button', ['url' => route('accounts.index'), 'color' => 'green'])
Get Started
@endcomponent

@endcomponent
