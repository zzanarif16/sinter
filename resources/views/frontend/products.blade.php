<x-layouts.site :title="'Products - Sumatera Interior'">
    <section class="page-section">
        <div class="page-header product-hub-shell p-6 sm:p-8">
            <h1 class="page-title">
                {{ $selectedFamily ? ucfirst(strtolower($selectedFamily)) . ' Product' : 'Product' }}
            </h1>
            <p class="page-subtitle">Eksplor koleksi curtain, blinds, railing, hook, dan motorized dengan tampilan yang lebih visual saat Anda memilih produk.</p>
            <div class="family-chips mt-5 flex flex-wrap gap-2">
                <a href="{{ route('products') }}" class="rounded-full border px-4 py-2 text-xs font-semibold {{ $selectedFamily ? 'border-sky-200 text-sky-700 hover:border-sky-500' : 'border-sky-600 bg-sky-700 text-white' }}">Semua</a>
                @foreach ($familyLinks as $family)
                <a href="{{ route('products.family', $family['slug']) }}" class="rounded-full border px-4 py-2 text-xs font-semibold {{ $selectedFamily === $family['key'] ? 'border-sky-600 bg-sky-700 text-white' : 'border-sky-200 text-sky-700 hover:border-sky-500' }}">{{ $family['label'] }}</a>
                @endforeach
            </div>
        </div>

        @forelse ($productsByFamily as $family => $familyProducts)
        <section class="surface-card mb-8 p-6 lg:p-7 detail-reveal" data-detail-reveal>
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-display text-2xl font-bold text-sky-900">{{ $family }}</h2>
                <span class="detail-chip">{{ $familyProducts->count() }} items</span>
            </div>

            <div class="family-grid mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($familyProducts as $product)
                <article class="product-card reveal-up p-4" data-product-card>
                    <div class="overflow-hidden rounded-xl bg-slate-100">
                        @if ($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-card-image h-48 w-full object-cover">
                        @else
                        <div class="flex h-48 items-center justify-center text-sm text-slate-400">No Image</div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold tracking-wide text-sky-700">{{ $sections[$product->section] ?? $product->section }}</p>
                        <h3 class="mt-1 font-display text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $product->short_description ?: 'Deskripsi singkat belum ditambahkan.' }}</p>

                        <a
                            href="{{ route('products.show', $product->slug) }}"
                            class="mt-4 inline-flex items-center gap-2 rounded-full bg-sky-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-800"
                            data-product-link>
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12h14m-6-6 6 6-6 6" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @empty
        <p class="text-slate-500">Belum ada data product. Silakan tambah dari admin panel.</p>
        @endforelse
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('js-ready');

            const productLinks = document.querySelectorAll('[data-product-link]');
            const revealItems = document.querySelectorAll('[data-detail-reveal]');

            if (revealItems.length > 0 && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries, io) {
                    entries.forEach(function(entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.2
                });

                revealItems.forEach(function(item) {
                    observer.observe(item);
                });
            } else {
                revealItems.forEach(function(item) {
                    item.classList.add('is-visible');
                });
            }

            productLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    const card = link.closest('[data-product-card]');
                    const targetUrl = link.getAttribute('href');

                    if (!card || !targetUrl) {
                        return;
                    }

                    event.preventDefault();
                    card.classList.add('product-card-leaving');

                    window.setTimeout(function() {
                        window.location.href = targetUrl;
                    }, 220);
                });
            });
        });
    </script>
</x-layouts.site>