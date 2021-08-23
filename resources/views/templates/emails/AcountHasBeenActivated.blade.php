@component('mail::message')
# Account has been activated

Hello, <?php echo $fullName; ?>, 

Your account has been activated!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
