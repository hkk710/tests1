@component('mail::message')
This mail was sent by {{ $data['name'] }}, {{ $data['email'] }}

{{ $data['feedback'] }}
@endcomponent
