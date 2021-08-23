@component('mail::message')
# Order Shipped

Hello, {{ ucwords($fullName) }}

Your order has shipped!

@component('mail::button', ['url' => $url])
Track Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
