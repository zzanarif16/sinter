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

<body class="zoom-bg min-h-screen text-slate-900 antialiased">
    @php
    $isContactSection = request()->routeIs('home');
    $navigationItems = [
    [
    'label' => 'Product',
    'url' => route('products'),
    'active' => request()->routeIs('products*'),
    ],
    [
    'label' => 'Inspiration',
    'url' => route('inspirations'),
    'active' => request()->routeIs('inspirations*'),
    ],
    [
    'label' => 'About',
    'url' => route('about'),
    'active' => request()->routeIs('about'),
    ],
    [
    'label' => 'Contact',
    'url' => route('home') . '#contact-footer',
    'active' => $isContactSection,
    ],
    ];
    @endphp

    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-50 border-b border-sky-100/80 bg-white/90 backdrop-blur">
            <nav class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8" aria-label="Main navigation">
                <div class="flex items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="font-display text-lg font-bold tracking-tight text-sky-900 sm:text-xl">Sumatera Interior</a>

                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-sky-200 p-2 text-sky-800 transition hover:bg-sky-50 md:hidden"
                        aria-expanded="false"
                        aria-controls="mobile-nav-drawer"
                        data-nav-toggle>
                        <span class="sr-only">Buka menu navigasi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>

                    <div class="hidden items-center gap-1 text-sm font-semibold text-slate-700 md:flex md:gap-2">
                        @foreach ($navigationItems as $item)
                        <a
                            href="{{ $item['url'] }}"
                            @class([ 'group relative rounded-full px-4 py-2 transition' , 'text-sky-900'=> $item['active'],
                            'hover:bg-sky-50 hover:text-sky-700' => !$item['active'],
                            ])>
                            {{ $item['label'] }}
                            <span
                                aria-hidden="true"
                                @class([ 'absolute inset-x-3 -bottom-0.5 h-0.5 rounded-full transition' , 'bg-sky-700 opacity-100'=> $item['active'],
                                'bg-sky-600 opacity-0 group-hover:opacity-60' => !$item['active'],
                                ])></span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </nav>
        </header>

        <div class="fixed inset-0 z-50 hidden md:hidden" data-mobile-nav-root>
            <button
                type="button"
                class="absolute inset-0 bg-slate-950/40 opacity-0 transition-opacity duration-300"
                aria-label="Tutup menu"
                data-mobile-nav-backdrop></button>

            <aside
                id="mobile-nav-drawer"
                class="mobile-drawer absolute right-0 top-0 flex h-full w-[82vw] max-w-sm translate-x-full flex-col border-l border-sky-100 bg-white shadow-2xl transition-transform duration-300"
                role="dialog"
                aria-modal="true"
                aria-label="Menu navigasi mobile"
                data-mobile-nav>
                <div class="flex items-center justify-between border-b border-sky-100 px-5 py-4">
                    <p class="font-display text-base font-semibold text-sky-900">Menu</p>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-sky-200 p-2 text-sky-800 transition hover:bg-sky-50"
                        aria-label="Tutup menu"
                        data-mobile-nav-close>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18" />
                        </svg>
                    </button>
                </div>

                <div class="grid gap-1 p-4 text-sm font-semibold text-slate-700">
                    @foreach ($navigationItems as $item)
                    <a
                        href="{{ $item['url'] }}"
                        @class([ 'relative rounded-xl px-4 py-3 transition' , 'bg-sky-50 text-sky-900'=> $item['active'],
                        'hover:bg-sky-50 hover:text-sky-700' => !$item['active'],
                        ])
                        data-mobile-nav-link>
                        {{ $item['label'] }}
                        <span
                            aria-hidden="true"
                            @class([ 'absolute left-1 top-1/2 h-6 -translate-y-1/2 rounded-full transition-all' , 'w-1 bg-sky-700 opacity-100'=> $item['active'],
                            'w-0 bg-sky-600 opacity-0' => !$item['active'],
                            ])></span>
                    </a>
                    @endforeach
                </div>
            </aside>
        </div>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer id="contact-footer" class="border-t border-sky-100 bg-white/80">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-8 text-sm text-slate-600 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    @php
                    $instagramValue = $footerContact?->instagram;
                    $instagramUrl = blank($instagramValue)
                    ? null
                    : (str_starts_with($instagramValue, 'http://') || str_starts_with($instagramValue, 'https://')
                    ? $instagramValue
                    : 'https://instagram.com/' . ltrim($instagramValue, '@'));

                    $whatsappValue = $footerContact?->whatsapp;
                    $whatsappDigits = $whatsappValue ? preg_replace('/[^0-9]/', '', $whatsappValue) : null;
                    $whatsappUrl = blank($whatsappDigits) ? null : 'https://wa.me/' . $whatsappDigits;

                    $mapValue = $footerContact?->map_embed;
                    $mapUrl = null;
                    $defaultLatitude = '-6.187111571220787';
                    $defaultLongitude = '106.81524925582019';
                    $defaultMapLinkUrl = 'https://www.google.com/maps?q=' . $defaultLatitude . ',' . $defaultLongitude;
                    $defaultMapEmbedUrl = 'https://maps.google.com/maps?q=' . $defaultLatitude . ',' . $defaultLongitude . '&z=15&output=embed';

                    if (!blank($mapValue)) {
                    if (preg_match('/src=["\']([^"\']+)["\']/', $mapValue, $matches)) {
                    $mapUrl = $matches[1];
                    } elseif (str_starts_with($mapValue, 'http://') || str_starts_with($mapValue, 'https://')) {
                    $mapUrl = $mapValue;
                    }
                    }
                    @endphp

                    <p class="font-semibold text-slate-800">Contact</p>
                    <ul class="mt-4 space-y-3">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25 10.89 13.26a2 2 0 0 0 2.22 0L21 8.25M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                            </svg>
                            @if ($footerContact?->email)
                            <a href="mailto:{{ $footerContact->email }}" class="hover:text-sky-700">{{ $footerContact->email }}</a>
                            @else
                            <span>Email belum diatur</span>
                            @endif
                        </li>

                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg>
                            @if ($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="hover:text-sky-700">{{ $instagramValue }}</a>
                            @else
                            <span>Instagram belum diatur</span>
                            @endif
                        </li>

                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-5.4-6-10a6 6 0 1 1 12 0c0 4.6-6 10-6 10Z" />
                                <circle cx="12" cy="11" r="2.5" />
                            </svg>
                            <span>{{ $footerContact?->address ?? 'Alamat belum diatur' }}</span>
                        </li>

                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5V12l3 2" />
                            </svg>
                            <span>{{ $footerContact?->business_hours ?? 'Jam operasional belum diatur' }}</span>
                        </li>

                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3h1.58a1.5 1.5 0 0 1 1.46 1.14l.5 2a1.5 1.5 0 0 1-.74 1.67l-1.2.67a11.04 11.04 0 0 0 5.17 5.17l.67-1.2a1.5 1.5 0 0 1 1.67-.74l2 .5A1.5 1.5 0 0 1 21 13.67v1.58a2.25 2.25 0 0 1-2.25 2.25h-.75C9.3 17.5 6.5 14.7 6.5 11V10.25A2.25 2.25 0 0 1 4.5 8V5.25Z" />
                            </svg>
                            @if ($footerContact?->phone)
                            <a href="tel:{{ $footerContact->phone }}" class="hover:text-sky-700">{{ $footerContact->phone }}</a>
                            @else
                            <span>Telepon belum diatur</span>
                            @endif
                        </li>

                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 5.5A8.5 8.5 0 0 1 21 12c0 4.7-3.8 8.5-8.5 8.5a8.47 8.47 0 0 1-4.04-1.02L3 21l1.52-5.22A8.47 8.47 0 0 1 3.5 12c0-3.22 1.79-6.03 4.43-7.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.4 9.8c.2-.44.42-.44.6-.44h.5c.15 0 .35-.03.55.4.2.43.67 1.45.73 1.55.06.1.1.22.02.36-.08.14-.13.23-.25.36-.12.12-.25.28-.36.37-.12.1-.24.2-.1.4.13.2.6.98 1.3 1.58.9.8 1.65 1.05 1.88 1.17.23.12.36.1.5-.06.13-.15.55-.63.7-.84.15-.21.3-.18.5-.1.2.08 1.28.6 1.5.72.22.11.36.17.41.26.05.1.05.56-.13 1.1-.18.54-1.03 1.03-1.43 1.08-.39.05-.89.07-1.44-.1a9.65 9.65 0 0 1-1.31-.6c-2.32-1-3.83-3.47-3.95-3.64-.12-.16-.94-1.25-.94-2.39 0-1.14.6-1.7.82-1.93Z" />
                            </svg>
                            @if ($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="hover:text-sky-700">{{ $whatsappValue }}</a>
                            @else
                            <span>WhatsApp belum diatur</span>
                            @endif
                        </li>

                    </ul>
                </div>
                <div class="lg:text-right">
                    <p class="mb-3 font-semibold text-slate-800">Lokasi Kami</p>
                    <div class="overflow-hidden rounded-xl border border-sky-100 shadow-sm">
                        <iframe
                            src="{{ $defaultMapEmbedUrl }}"
                            width="100%"
                            height="220"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Google Maps Sumatera Interior">
                        </iframe>
                    </div>
                    <a href="{{ $mapUrl ?: $defaultMapLinkUrl }}" target="_blank" rel="noopener" class="mt-3 inline-flex rounded-full bg-sky-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-800">Buka di Maps</a>
                </div>

            </div>
            <div class="py-4 text-xs text-slate-600 lg:text-center border-t border-sky-100">
                <p>Copyright {{ now()->year }} Sumatera Interior</p>
            </div>
        </footer>
    </div>
</body>

</html>