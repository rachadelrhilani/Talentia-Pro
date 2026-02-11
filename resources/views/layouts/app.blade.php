<!DOCTYPE html>
<html lang="fr">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Talentia Pro - La plateforme de recrutement pour les talents et les entreprises.')">
    <meta name="keywords" content="@yield('meta_keywords', 'emploi, recrutement, carriere, talent, entreprise, au maroc, stage, pfe, cdi, cdd, freelance')">
    <meta name="author" content="Talentia Pro">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Talentia Pro')">
    <meta property="og:description" content="@yield('meta_description', 'Talentia Pro - La plateforme de recrutement pour les talents et les entreprises.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Talentia Pro')">
    <meta property="twitter:description" content="@yield('meta_description', 'Talentia Pro - La plateforme de recrutement pour les talents et les entreprises.')">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <title>@yield('title', 'Talentia Pro')</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 4px !important;
        }
    </style>
    @endpush

    {{-- Zid had l-script l-te7t dyal l-page --}}
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#skills-select').select2({
                tags: true, // Hadi hya li katsme7 t-zid jdad
                tokenSeparators: [',', ' '],
                placeholder: "Sélectionnez ou ajoutez des compétences"
            });
        });
    </script>
    @endpush
</head>

<body class="bg-gray-100">

    @include('components.navbar')

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>
    @livewireScripts
    @stack('scripts')
</body>

</html>