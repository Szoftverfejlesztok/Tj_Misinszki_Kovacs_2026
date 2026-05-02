<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        
        <link
            href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
            rel="stylesheet">

        <link
            href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&display=swap"
            rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>

    <body class="landing-bg">
        <header class="top-nav">
            @if (Route::has('login'))
                <nav class="auth-links">
                    <a href="{{ route('login') }}" class="login">
                        Bejelentkezés
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register">
                            Regisztráció
                        </a>
                    @endif
                </nav>
            @endif
        </header>

        <img
            src="{{ asset('images/DSC_1750.jpg') }}"
            alt="Dorm Log háttér"
            class="landing-image"
        >

        <div class="container">
            <div class="title">DORM LOG</div>

            <p class="text">
                Üdvözöljük a Dorm Log weboldalán!<br>
                Kérjük, regisztráljon vagy jelentkezzen be.
            </p>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>