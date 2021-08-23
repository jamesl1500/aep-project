@component('mail::message')
# Order Confirmation

Hello, {{ ucwords($fullName) }}

Your order has been confirmed and is now processing!

@component('mail::button', ['url' => $url])
View order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
