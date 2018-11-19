<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include("layouts.pageInfo")
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
</head>
<body>
    <div id="app">
        @include("layouts.nav")
        <main class="py-4">
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <p class="text-center">@2015-{{ \Carbon\Carbon::now()->addDays(3)->year }} <a href="{{config("github.homepage")}}" target="_blank">Mark</a> 版权所有</p>
                <p class="text-center">鄂ICP备16011870号-1</p>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('custom-js')
</body>
</html>
