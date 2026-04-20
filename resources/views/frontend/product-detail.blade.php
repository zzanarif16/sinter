<x-layouts.site :title="$product->name . ' - Product Detail'">
    <section class="page-section">
        @php
        $galleryItems = $product->gallery_items;
        $galleryImages = collect($galleryItems)->pluck('image_url')->all();
        $galleryDetailByImage = collect($galleryItems)
            ->mapWithKeys(fn(array $item): array => [
                $item['image_url'] => $item['detail'] ?? null,
            ])
            ->all();
        $mainImage = $product->image_url ?? ($galleryImages[0] ?? null);
        $mainImageDetail = $mainImage ? ($galleryDetailByImage[$mainImage] ?? null) : null;
        $allImages = array_values(array_unique(array_filter(array_merge([$mainImage], $galleryImages))));
        $sectionLabel = $sections[$product->section] ?? $product->section;
        @endphp

        <a href="{{ route('products') }}" class="mb-7 inline-flex items-center gap-2 text-sm font-semibold text-sky-700 transition hover:text-sky-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
            </svg>
            Kembali ke Product
        </a>

        <article class="product-hub-shell grid gap-7 p-4 sm:p-6 lg:grid-cols-[1.1fr_.9fr] lg:gap-8 lg:p-8">
            <div class="detail-reveal min-w-0" data-detail-reveal>
                <div class="space-y-4 sm:space-y-5">
                    <div>
                        @if ($mainImage)
                        <button
                            type="button"
                            class="detail-main-visual h-[23rem] w-full sm:h-[30rem]"
                            data-gallery-open
                            data-gallery-image="{{ $mainImage }}"
                            data-gallery-detail="{{ $mainImageDetail ?? '' }}"
                            aria-label="Perbesar foto {{ $product->name }}">
                            <img src="{{ $mainImage }}" alt="{{ $product->name }}" data-gallery-main-image>
                            <span class="absolute bottom-4 left-4 rounded-full bg-slate-950/70 px-3 py-1 text-xs font-semibold text-white">Tap untuk zoom</span>
                        </button>

                        @if (!empty($allImages))
                        <p class="mt-3 text-sm leading-6 text-slate-600" data-gallery-main-detail>{{ $mainImageDetail ?? '' }}</p>
                        @endif
                        @else
                        <div class="detail-main-visual flex h-[23rem] w-full items-center justify-center text-slate-400 sm:h-[30rem]">No Image</div>
                        @endif
                    </div>

                    @if (!empty($allImages))
                    <div class="detail-carousel-wrap">
                        <button type="button" class="detail-carousel-nav" data-gallery-prev aria-label="Geser sub foto ke kiri">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                            </svg>
                        </button>

                        <div class="detail-carousel-track" data-gallery-track>
                            @foreach ($allImages as $index => $thumbImage)
                            @php
                            $thumbDetail = $galleryDetailByImage[$thumbImage] ?? null;
                            @endphp
                            <button
                                type="button"
                                class="detail-thumb detail-thumb-card {{ $index === 0 ? 'is-active' : '' }} flex flex-shrink-0 snap-start flex-col overflow-hidden"
                                data-gallery-thumb
                                data-gallery-image="{{ $thumbImage }}"
                                data-gallery-detail="{{ $thumbDetail ?? '' }}"
                                aria-label="Tampilkan foto {{ $index + 1 }} {{ $product->name }}">
                                <img src="{{ $thumbImage }}" alt="{{ $product->name }} sub foto {{ $index + 1 }}" class="h-16 w-full object-cover sm:h-20">
                                <span class="detail-thumb-caption px-2 py-1 text-center text-xs leading-7 text-slate-600">{{ $thumbDetail ?? '' }}</span>
                            </button>
                            @endforeach
                        </div>

                        <button type="button" class="detail-carousel-nav" data-gallery-next aria-label="Geser sub foto ke kanan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <div class="detail-panel detail-reveal p-6 sm:p-7" data-detail-reveal>
                <div class="mb-4 flex flex-wrap gap-2">
                    <span class="detail-chip">{{ $product->family }}</span>
                    <span class="detail-chip">{{ $sectionLabel }}</span>
                </div>

                <h1 class="page-title text-3xl sm:text-4xl">{{ $product->name }}</h1>

                @if ($product->price)
                <p class="mt-4 text-2xl font-bold text-sky-900">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                @endif

                <p class="mt-5 text-sm leading-7 text-slate-600 sm:text-base">{{ $product->short_description ?: 'Produk premium interior untuk kebutuhan hunian maupun komersial.' }}</p>

                @if ($product->description)
                <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 text-sm leading-7 text-slate-700">
                    {!! nl2br(e($product->description)) !!}
                </div>
                @endif

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}#contact-footer" class="inline-flex items-center justify-center rounded-full bg-sky-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-800">Konsultasi Sekarang</a>
                </div>
            </div>
        </article>

        @if ($relatedProducts->isNotEmpty())
        <section class="mt-12 detail-reveal" data-detail-reveal>
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-display text-2xl font-bold text-slate-900">Produk Terkait</h2>
                <span class="detail-chip">Rekomendasi</span>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedProducts as $item)
                <article class="detail-related-card p-4" data-product-card>
                    @if ($item->image_url)
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="product-card-image mb-3 h-40 w-full rounded-xl object-cover">
                    </div>
                    @endif
                    <h3 class="font-display text-base font-semibold text-slate-900">{{ $item->name }}</h3>
                    <a href="{{ route('products.show', $item->slug) }}" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-sky-700 hover:text-sky-900" data-related-product-link>
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12h14m-6-6 6 6-6 6" />
                        </svg>
                    </a>
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
            document.documentElement.classList.add('js-ready');

            const mainImage = document.querySelector('[data-gallery-main-image]');
            const mainTrigger = document.querySelector('[data-gallery-open]');
            const mainDetail = document.querySelector('[data-gallery-main-detail]');
            const thumbs = document.querySelectorAll('[data-gallery-thumb]');
            const track = document.querySelector('[data-gallery-track]');
            const prevButton = document.querySelector('[data-gallery-prev]');
            const nextButton = document.querySelector('[data-gallery-next]');
            const modal = document.querySelector('[data-gallery-modal]');
            const modalImage = document.querySelector('[data-gallery-zoom-image]');
            const closeButton = document.querySelector('[data-gallery-close]');
            const revealItems = document.querySelectorAll('[data-detail-reveal]');
            const relatedLinks = document.querySelectorAll('[data-related-product-link]');

            const updateCarouselButtons = function() {
                if (!track || !prevButton || !nextButton) {
                    return;
                }

                const maxScrollLeft = track.scrollWidth - track.clientWidth;
                const canScroll = maxScrollLeft > 5;

                prevButton.disabled = !canScroll || track.scrollLeft <= 4;
                nextButton.disabled = !canScroll || track.scrollLeft >= maxScrollLeft - 4;
            };

            if (revealItems.length > 0 && 'IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver(function(entries, io) {
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
                    revealObserver.observe(item);
                });
            } else {
                revealItems.forEach(function(item) {
                    item.classList.add('is-visible');
                });
            }

            const setActiveThumb = function(imageUrl) {
                thumbs.forEach(function(thumb) {
                    thumb.classList.toggle('is-active', thumb.dataset.galleryImage === imageUrl);
                });
            };

            const swapMainImage = function(imageUrl, imageDetail) {
                if (!mainImage || !mainTrigger || !imageUrl) {
                    return;
                }

                const visual = mainTrigger.closest('.detail-main-visual');
                if (visual) {
                    visual.classList.add('is-swapping');
                }

                window.setTimeout(function() {
                    mainImage.src = imageUrl;
                    mainTrigger.dataset.galleryImage = imageUrl;
                    mainTrigger.dataset.galleryDetail = imageDetail || '';

                    if (mainDetail) {
                        mainDetail.textContent = imageDetail || 'Detail singkat belum ditambahkan.';
                    }

                    setActiveThumb(imageUrl);

                    const activeThumb = Array.from(thumbs).find(function(thumb) {
                        return thumb.dataset.galleryImage === imageUrl;
                    });

                    if (activeThumb && track) {
                        activeThumb.scrollIntoView({
                            behavior: 'smooth',
                            inline: 'nearest',
                            block: 'nearest',
                        });
                    }

                    if (visual) {
                        visual.classList.remove('is-swapping');
                    }
                }, 120);
            };

            const openModal = function(imageUrl) {
                if (!modal || !modalImage) {
                    return;
                }

                modalImage.src = imageUrl;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.classList.remove('gallery-modal-leave');
                modal.classList.add('gallery-modal-enter');
                document.body.classList.add('overflow-hidden');
                modal.setAttribute('aria-hidden', 'false');
            };

            const closeModal = function() {
                if (!modal) {
                    return;
                }

                modal.classList.remove('gallery-modal-enter');
                modal.classList.add('gallery-modal-leave');

                window.setTimeout(function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modal.classList.remove('gallery-modal-leave');
                    modal.setAttribute('aria-hidden', 'true');
                }, 180);

                document.body.classList.remove('overflow-hidden');
            };

            thumbs.forEach(function(thumb) {
                thumb.addEventListener('click', function() {
                    const imageUrl = thumb.dataset.galleryImage;
                    const imageDetail = thumb.dataset.galleryDetail || '';

                    if (!imageUrl) {
                        return;
                    }

                    swapMainImage(imageUrl, imageDetail);
                });
            });

            if (mainTrigger) {
                mainTrigger.addEventListener('click', function() {
                    const imageUrl = mainTrigger.dataset.galleryImage;

                    if (!imageUrl) {
                        return;
                    }

                    openModal(imageUrl);
                });
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            relatedLinks.forEach(function(link) {
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

            if (thumbs.length > 0 && mainTrigger) {
                setActiveThumb(mainTrigger.dataset.galleryImage || '');
            }

            if (track && prevButton && nextButton) {
                const getScrollAmount = function() {
                    return Math.max(track.clientWidth * 0.82, 260);
                };

                prevButton.addEventListener('click', function() {
                    track.scrollBy({
                        left: -getScrollAmount(),
                        behavior: 'smooth',
                    });
                });

                nextButton.addEventListener('click', function() {
                    track.scrollBy({
                        left: getScrollAmount(),
                        behavior: 'smooth',
                    });
                });

                track.addEventListener('scroll', updateCarouselButtons, {
                    passive: true,
                });

                window.addEventListener('resize', updateCarouselButtons);
                updateCarouselButtons();
            }
        });
    </script>
</x-layouts.site>