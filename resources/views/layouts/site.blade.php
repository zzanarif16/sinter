<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sumatera Interior' }}</title>
    <meta name="description" content="Sumatera Interior - Product, Inspiration, About, Contact">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- <body class="zoom-bg text-slate-900 antialiased">
    <header class="sticky top-0 z-50 border-b border-sky-100/80 bg-white/90 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="font-display text-xl font-bold tracking-tight text-sky-900">Sumatera Interior</a>
            <div class="flex items-center gap-4 text-sm font-semibold text-slate-700 sm:gap-6">
                <a href="{{ route('products') }}" class="hover:text-sky-700">Product</a>
                <a href="{{ route('inspirations') }}" class="hover:text-sky-700">Inspiration</a>
                <a href="{{ route('about-contact') }}" class="hover:text-sky-700">About/Contact</a>
                <a href="/admin" class="rounded-full bg-sky-700 px-4 py-2 text-white transition hover:bg-sky-800">Login CMS</a>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-sky-100 bg-white/80">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-8 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>Copyright {{ now()->year }} Sumatera Interior</p>
            <p>Built with Laravel + Filament + Tailwind</p>
        </div>
    </footer>
</body> -->

</html>