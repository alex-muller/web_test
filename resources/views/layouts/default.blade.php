<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (Auth::check())
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif

    <title>App</title>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div id="app">
        <router-view></router-view>
    </div>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
