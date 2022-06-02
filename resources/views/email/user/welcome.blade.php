@component('vendor.mail.markdown.message')

    # Welcome to {{ config('app.name') }}

{{--    Hi {{ $name }},--}}

{{--    We are glad to have you on board.--}}

{{--    @if(!is_null($password))--}}
{{--        Your login details are as follows:--}}

{{--        **Email**: {{ $email }}--}}

{{--        **Password**: {{ $password }}--}}

{{--        You can change your password once logged-in.--}}
{{--    @else--}}
{{--        Please ask site administrator to know your login access.--}}
{{--    @endif--}}

{{--    @component('vendor.mail.markdown.button', ['url' => url('login')])--}}
{{--        Visit site--}}
{{--    @endcomponent--}}

    Thanks,
    {{ config('app.name') }}
@endcomponent
