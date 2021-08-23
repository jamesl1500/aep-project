@component('mail::message')
# Account Under Review

Hello, {{ ucwords($fullName) }}

Your account is under review and we will notify you when it's been activated!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
