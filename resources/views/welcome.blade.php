<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ route('home', app()->getLocale()) }}">{{ __('Home') }}</a>
            @else
            <a href="{{ route('login', app()->getLocale()) }}">{{ __('Login') }}</a>

            @if (Route::has('register'))
            <a href="{{ route('register', app()->getLocale()) }}">{{ __('Register') }}</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                {{ config('app.name') }}
            </div>

            <div class="links">
                <a href="https://www.karomap.com" target="_blank">Karomap</a>
                <a href="https://github.com/karomap/laravel-test" target="_blank">GitHub</a>
            </div>
        </div>
    </div>
</body>

</html>
