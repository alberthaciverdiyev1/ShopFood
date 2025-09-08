<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Shop Food')</title>

    <meta name="description"
          content="@yield('meta_description', 'Buy fresh and tasty food online. Fast delivery and best prices.')">

    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="@yield('title', 'Shop Food')">
    <meta property="og:description"
          content="@yield('meta_description', 'Buy fresh and tasty food online. Fast delivery and best prices.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-default.png'))">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    @vite('resources/css/app.css')

    @yield('styles')
</head>
<body>

<header>
    @if(!isset($hideNavbar) || !$hideNavbar)
        @include('partials.navbar')
    @endif
</header>


<main>
    @yield('content')
</main>

<footer>
    <p>&copy; 2025 Shop Food. All rights reserved.</p>
</footer>

@vite('resources/js/app.js')

@yield('scripts')
</body>
</html>
