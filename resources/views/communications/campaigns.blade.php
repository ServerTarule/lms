<x-mail::message>

{{--The body of your message.--}}
<body>
<div>{{ $emailBody }}</div>
</body>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks You,<br>
{{ config('app.name') }}
</x-mail::message>
