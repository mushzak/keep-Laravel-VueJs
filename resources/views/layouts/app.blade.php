<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    {{-- Required Meta tags for responsive design -- keep these on top.--}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Other meta tags --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pusher-key" content="{{ config('broadcasting.connections.pusher.key') }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/Keepical_Logo_12.20.2017_l0w.png') }}">
    <link rel="icon" sizes="32x32" href="{{ asset('/images/Keepical_Logo_12.20.2017_l0w.png') }}">
    <link rel="icon" sizes="16x16"  href="{{ asset('/images/Keepical_Logo_12.20.2017_l0w.png') }}">
    {{-- Stylesheets --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" >

    @if (config('debugbar.enabled') !== false)
        {!! Debugbar::getJavascriptRenderer()->renderHead() !!}
    @endif

    @include('layouts._google_analytics')
</head>
<body>
<div id="app">
    @include('layouts._header')

    <main class="mb-3 d-flex flex-column justify-content-start">
        @yield('content')
    </main>

    @include('flash::message')

    @section('footer')
        @include('layouts._footer')
    @show
</div>

@if (config('debugbar.enabled') !== false)
    {!! Debugbar::getJavascriptRenderer()->render() !!}
@endif

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
