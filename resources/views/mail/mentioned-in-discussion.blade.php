@component('mail::message')
# Mentioned in discussion

You have been mentioned in a discussion:

{{ $discussion->content }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
