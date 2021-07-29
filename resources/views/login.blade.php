<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8" />
        <link href="{{ mix('css/login.css') }}" rel="stylesheet">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->
    </head>
    <body>
        <div class="main">
            <h1 class="title">KORDs v5</h1>
            <a href="/oauth">
                <img src="/img/raven.png" class="raven-img" />
                <span>Login with Raven</span>
            </a>
        </div>
    </body>
</html>
