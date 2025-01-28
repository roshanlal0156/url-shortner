<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'URL SHORTNER')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . time()) }}">
</head>
<body>
    @include('components.navbar')
    <div class="content container">
        @yield('content')
    </div>
    @include('components.footer')
</body>
<script src="{{ asset('js/app.js?v=' . time()) }}"></script>
</html>