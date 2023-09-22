<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- CSSファイルは今回はトップページにのみ必要なため、CSSファイルを読み込みたい位置で@stackを記述する（子ビューのindexファイルで@pusu~@endpush内にファイルを読み込みコードを記述して完成 --}}
    @stack('styles')
</head>
<body style="padding: 60px 0;">
    <div id="app">
        @include('layouts.header')

        <main class="py-4">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    {{-- JavaScriptファイルをトップページでのみ読み込めるように修正する。これは親ビューのため、読み込みたい①に@stackを記述 --}}
    {{-- <script src="{{ asset('/js/script.js') }}"></script>だったのを下記に置き換える --}}
    @stack('scripts')
</body>
</html>
