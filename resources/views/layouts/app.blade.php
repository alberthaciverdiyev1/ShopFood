<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Shop Food')</title>

    @vite('resources/css/app.css')

    @yield('styles')
</head>
<body>

    <header>
        @include('partials.navbar')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Copyright &copy; 2025</p>
    </footer>

    @vite('resources/js/app.js')

    @yield('scripts')

</body>
</html>
