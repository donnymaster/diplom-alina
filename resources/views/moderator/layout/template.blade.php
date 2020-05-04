<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

   <link rel="shortcut icon" href="{{ asset('img/icon.ico') }}" type="image/x-icon">

   <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=cyrillic"
   rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap&subset=cyrillic"
   rel="stylesheet">
   @hasSection('lib-css')
        @yield('lib-css')
    @endif

   <title>@yield('title')</title>
 </head>
<body>
    @include('moderator.layout.sidebar')
    <main class="main">
        @include('moderator.layout.header')
        <div class="page">
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('js/app.min.js') }}" defer></script>

    @hasSection('scriptUser')
        @yield('scriptUser')
    @endif
    @hasSection('script')
        @yield('script')
    @endif

    @hasSection('in-body')
        @yield('in-body')
    @endif
</body>
