<x-layouts.site :title="'Products - Sumatera Interior'">
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="font-display text-4xl font-bold text-slate-900">
                {{ $selectedFamily ? ucfirst(strtolower($selectedFamily)) . ' Product' : 'Product' }}
            </h1>
            <p class="mt-3 max-w-2xl text-slate-600">Kategori produk dikelompokkan sesuai kebutuhan CURTAIN, BLINDS, RAILING, HOOK, dan MOTORIZED.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('products') }}" class="rounded-full border px-4 py-2 text-xs font-semibold {{ $selectedFamily ? 'border-sky-200 text-sky-700 hover:border-sky-500' : 'border-sky-600 bg-sky-700 text-white' }}">Semua</a>
                @foreach ($familyLinks as $family)
                <a href="{{ route('products.family', $family['slug']) }}" class="rounded-full border px-4 py-2 text-xs font-semibold {{ $selectedFamily === $family['key'] ? 'border-sky-600 bg-sky-700 text-white' : 'border-sky-200 text-sky-700 hover:border-sky-500' }}">{{ $family['label'] }}</a>
                @endforeach
            </div>
        </div>

        @forelse ($productsByFamily as $family => $familyProducts)
        <section class="mb-10 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="font-display text-2xl font-bold text-sky-900">{{ $family }}</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($familyProducts as $product)
                <article class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                    @if ($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-3 h-40 w-full rounded-xl object-cover">
                    @endif
                    <p class="text-xs font-semibold tracking-wide text-sky-700">{{ $sections[$product->section] ?? $product->section }}</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $product->short_description ?: 'Deskripsi singkat belum ditambahkan.' }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="mt-4 inline-flex rounded-full bg-sky-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-800">Detail</a>
                </article>
                @endforeach
            </div>
        </section>
        @empty
        <p class="text-slate-500">Belum ada data product. Silakan tambah dari admin panel.</p>
        @endforelse
    </section>
</x-layouts.site>