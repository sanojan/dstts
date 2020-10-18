<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    
        <div class="flex-center position-ref full-height">
            <div class="top-right links">
            <a href="{{ route(Route::currentRouteName(), 'en') }}">English</a>
            <a href="{{ route(Route::currentRouteName(), 'si') }}">සිංහල</a>
            <a href="{{ route(Route::currentRouteName(), 'ta') }}">தமிழ்</a>
            @if (Route::has('login'))
                
                    @auth
                        <a href="{{ route('home', app()->getLocale()) }}">Home</a>
                    @else
                        <a href="{{ route('login', app()->getLocale())}}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register', app()->getLocale()) }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                {{ __("Task Tracking System") }}
                </div>
                <div class="m-b-md"><h2>
                {{ __("District Secretariat - Ampara") }}</h2>
                </div>
                <div class="m-b-md"><h5>
                &copy;2020 <a href="#">District Secretariat - Ampara</a>.</h5>
                </div>
                
            </div>
        </div>
        
    </body>
</html>
