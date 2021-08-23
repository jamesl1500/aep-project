@component('mail::message')
    # Contact Form

    From, {{ ucwords($firstname) }} {{ ucwords($lastname) }} (<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>)

    <b>Subject</b>: {{ ucwords($subject) }}

    <b>Message</b>
    <p><?php echo $message; ?></p>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
