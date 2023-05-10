<x-mail::message>
The body of your message.

@component('mail::button', ['url' => 'http://localhost:'. env('VUE_PORT').'/resetpassword/'. $token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
