<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        bubbly({
            colorStart: "#fff4e6",
            colorStop: "#ffe9e4",
            blur: 2,
            bubbles: 40,
            compose: "source-over",
            bubbleFunc: () => `hsla(${Math.random() * 50}, 100%, 50%, .3)`
        });
    </script>
    <!-- <script src="http://maps.google.com/maps/api/js?key=AIzaSyDVcINCNOxYqEzXVm1TmUHy8OVeLuDB2mA&language=ja"></script> -->
    <div id="app">
        <script src="{{ mix('/js/app.js') }}"></script>
    </div>
</body>

</html>
<!-- {{-- <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
    @endif
    @endauth
    </div>
    @endif
    </div> --}} -->