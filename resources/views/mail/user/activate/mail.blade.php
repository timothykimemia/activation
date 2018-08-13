@component('mail::message')
# Welcome {{ $token->user->name }}

Please activate your account.

@component('mail::button', ['url' => route('activate.email', $token)])
Activate Account
@endcomponent

@component('mail::panel')
If you having trouble click on this direct link [{{ route('activate.email', $token) }}]({{ route('activate.email', $token) }}).
@endcomponent

@component('mail::panel')
If you did not request Activation for your Profile Account. Please ignore.
@endcomponent

Thank you for choosing {{ config('app.name') }},<br>

[{{ config('app.name') }}]({{ route('index') }}).
@endcomponent
