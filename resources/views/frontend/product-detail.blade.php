<x-layouts.site :title="$product->name . ' - Product Detail'">
    <section class="page-section">
        <a href="{{ route('products') }}" class="mb-6 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900">&larr; Kembali ke Product</a>

        <article class="surface-card grid gap-8 p-6 lg:grid-cols-2 lg:p-8">
            <div>
                @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-80 w-full rounded-2xl object-cover lg:h-[28rem]">
                @else
                <div class="flex h-80 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 lg:h-[28rem]">No Image</div>
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
</x-layouts.site>