<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8" />
        <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons+Round" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->
    </head>
    <body>
        <div id="app"></div>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>
