<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    @include('layouts.partials.favicon')
    @include('layouts.partials.tags')
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
    <script src="{{ url(mix('js/app.js')) }}" defer></script>
    {{-- {{ isset($title) ? $title." |" : "" }}  --}}
    <title>{{ config('APP_NAME', 'Khatti Toufi') }}</title>
    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};
    </script>
</head>
<body class="w-full min-h-screen antialiased leading-none font-body">
    <div class="flex flex-col min-w-full min-h-screen bg-background" id="app">
        <router-view></router-view>
    </div>
</body>
</html>