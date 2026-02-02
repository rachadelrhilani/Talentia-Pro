<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Job Platform')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    @include('components.navbar')

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

</body>
</html>
