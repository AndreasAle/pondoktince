<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic SEO: title, meta, OG, Twitter, canonical, JSON-LD --}}
    {!! seo()->render() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if($siteSettings->favicon_path)
        <link rel="icon" href="{{ media_url($siteSettings->favicon_path) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if($siteSettings->head_scripts)
        {!! $siteSettings->head_scripts !!}
    @endif
</head>
<body class="min-h-screen bg-cream-50 font-sans text-charcoal antialiased">

    @include('partials.header')

    <main>
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Floating WhatsApp button --}}
    <x-wa-button
        :message="'Halo '.$siteSettings->site_name.', saya ingin bertanya.'"
        label="Chat WhatsApp"
        source="floating"
        floating />

    @stack('scripts')
</body>
</html>
