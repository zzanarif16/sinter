<x-layouts.site :title="$product->name . ' - Product Detail'">
    <section class="page-section">
        <a href="{{ route('products') }}" class="mb-6 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900">&larr; Kembali ke Product</a>

        @php
        $galleryImages = $product->gallery_image_urls;
        $mainImage = $product->image_url ?? ($galleryImages[0] ?? null);
        @endphp

        <article class="surface-card grid gap-8 p-6 lg:grid-cols-2 lg:p-8">
            <div>
                @if ($mainImage)
                <button
                    type="button"
                    class="w-full"
                    data-gallery-open
                    data-gallery-image="{{ $mainImage }}"
                    aria-label="Zoom foto {{ $product->name }}">
                    <img
                        src="{{ $mainImage }}"
                        alt="{{ $product->name }}"
                        class="h-80 w-full rounded-2xl object-cover lg:h-[28rem]"
                        data-gallery-main-image>
                </button>
                @else
                <div class="flex h-80 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 lg:h-[28rem]">No Image</div>
                @endif

                @if (!empty($galleryImages))
                <div class="mt-4 grid grid-cols-5 gap-3">
                    @foreach ($galleryImages as $index => $subImage)
                    <button
                        type="button"
                        class="group overflow-hidden rounded-xl border border-slate-200 transition hover:border-sky-500"
                        data-gallery-thumb
                        data-gallery-image="{{ $subImage }}"
                        aria-label="Lihat sub foto {{ $index + 1 }} {{ $product->name }}">
                        <img src="{{ $subImage }}" alt="{{ $product->name }} sub foto {{ $index + 1 }}" class="h-16 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-20">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold tracking-wide text-sky-700">{{ $product->family }} / {{ $sections[$product->section] ?? $product->section }}</p>
                <h1 class="mt-2 page-title text-3xl sm:text-4xl">{{ $product->name }}</h1>

                @if ($product->price)
                <p class="mt-4 text-2xl font-bold text-sky-900">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                @endif

                <p class="mt-4 text-slate-600">{{ $product->short_description }}</p>

                @if ($product->description)
                <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                    {!! nl2br(e($product->description)) !!}
                </div>
                @endif
            </div>
        </article>

        @if ($relatedProducts->isNotEmpty())
        <section class="mt-12">
            <h2 class="font-display text-2xl font-bold text-slate-900">Produk Terkait</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedProducts as $item)
                <article class="surface-card p-4">
                    @if ($item->image_url)
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="mb-3 h-36 w-full rounded-xl object-cover">
                    @endif
                    <h3 class="font-display text-base font-semibold text-slate-900">{{ $item->name }}</h3>
                    <a href="{{ route('products.show', $item->slug) }}" class="mt-3 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900">Lihat Detail</a>
                </article>
                @endforeach
            </div>
        </section>
        @endif
    </section>

    <div class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/85 p-4" data-gallery-modal aria-hidden="true">
        <button type="button" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Tutup zoom foto" data-gallery-close>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18" />
            </svg>
        </button>

        <img src="" alt="Zoom foto {{ $product->name }}" class="max-h-[88vh] w-auto max-w-full rounded-2xl object-contain transition-transform duration-300" data-gallery-zoom-image>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.querySelector('[data-gallery-main-image]');
            const mainTrigger = document.querySelector('[data-gallery-open]');
            const thumbs = document.querySelectorAll('[data-gallery-thumb]');
            const modal = document.querySelector('[data-gallery-modal]');
            const modalImage = document.querySelector('[data-gallery-zoom-image]');
            const closeButton = document.querySelector('[data-gallery-close]');

            if (!mainImage || !mainTrigger || !modal || !modalImage || !closeButton) {
                return;
            }

            const openModal = function(imageUrl) {
                modalImage.src = imageUrl;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modalImage.classList.add('scale-100');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            };

            thumbs.forEach(function(thumb) {
                thumb.addEventListener('click', function() {
                    const imageUrl = thumb.dataset.galleryImage;

                    if (!imageUrl) {
                        return;
                    }

                    mainImage.src = imageUrl;
                    mainTrigger.dataset.galleryImage = imageUrl;
                    openModal(imageUrl);
                });
            });

            mainTrigger.addEventListener('click', function() {
                const imageUrl = mainTrigger.dataset.galleryImage;

                if (!imageUrl) {
                    return;
                }

                openModal(imageUrl);
            });

            closeButton.addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
</x-layouts.site>