<!DOCTYPE HTML>
@if(!Session::has('logged'))

    <script>
        window.location.href = '{{ url('/') }}';
    </script>


@elseif(Session::has('logged'))

    <html lang="en-US">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('layouts.head')
    </head>
    <body>
    @include('layouts.header')
    @yield('master')
    @include('layouts.footer')
    @include('layouts.js')
    @yield('js')
    </body>
    </html>
@endif