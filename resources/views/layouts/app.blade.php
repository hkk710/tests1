<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Enduro Innovative is a startup launched in 2020 by a group of passionate engineering students of Amrita Institute. The primary purpose of this startup is to conduct research on innovative eco-friendly technology and use their practical applications to design products and provide services." />
    <link rel="icon" href="{{ asset('favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title'){{ config('app.name', 'Enduro') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    @yield('styles')
</head>
<body>
    <div id="app">
        <alert-component message="{{ Session::get('success') }}"></alert-component>

        @yield('content')
    </div>

    @yield('post_content')
</body>
</html>
