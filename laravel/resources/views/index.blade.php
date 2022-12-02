<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{url('css/app.css')}}" rel="stylesheet">
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="root-container">
            @auth
                @yield('content-app')
            @else
                @yield('content-auth')
            @endauth
        </div>
        <script src="{{url('js/index.js')}}"></script>
    </body>
</html>
