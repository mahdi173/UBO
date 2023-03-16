<x-mail::message>
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://localhost:80/reset-password/'. $token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
