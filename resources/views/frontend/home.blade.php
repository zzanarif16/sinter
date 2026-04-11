<x-layouts.site :title="'Sumatera Interior'">
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,#bae6fd_0%,transparent_45%),radial-gradient(circle_at_bottom_left,#c7d2fe_0%,transparent_40%)]"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-30">
            <p class="mb-4 inline-flex rounded-full border border-sky-200 bg-white/70 px-4 py-1 text-xs font-semibold tracking-[0.18em] text-sky-700">SUMATERA INTERIOR</p>
            <h1 class="font-display max-w-4xl text-4xl font-bold leading-tight text-sky-950 sm:text-5xl lg:text-6xl">
                Menghadirkan Keindahan dan Kenyamanan dalam Setiap Sudut Ruang Anda
            </h1>
            <p class="mt-6 max-w-2xl text-lg text-slate-600">
                Sumatera Interior menghadirkan desain yang menyatu antara estetika, fungsi, dan karakter untuk menciptakan hunian yang benar-benar terasa hidup.
            </p>
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="{{ route('products') }}" class="rounded-full bg-sky-700 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-800">Lihat Product</a>
                <a href="{{ route('inspirations') }}" class="rounded-full border border-sky-200 bg-white px-6 py-3 text-sm font-semibold text-sky-900 hover:bg-sky-50">Lihat Inspiration</a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-end justify-between">
            <h2 class="font-display text-2xl font-bold text-sky-900">Featured Product</h2>
            <a href="{{ route('products') }}" class="text-sm font-semibold text-sky-700">Lihat semua</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($featuredFamilies as $family)
            <a href="{{ route('products.family', $family['slug']) }}" class="reveal-up group rounded-2xl border border-sky-200 bg-white p-5 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-500 hover:shadow-lg">
                <p class="text-xs font-semibold tracking-[0.18em] text-sky-500">FAMILY</p>
                <h3 class="font-display mt-2 text-2xl font-bold text-sky-900">{{ $family['label'] }}</h3>
                <p class="mt-3 text-sm font-semibold text-sky-700 transition group-hover:text-sky-900">Lihat Produk</p>
            </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-end justify-between">
            <h2 class="font-display text-2xl font-bold text-sky-900">Inspiration</h2>
            <a href="{{ route('inspirations') }}" class="text-sm font-semibold text-sky-700">Lihat Selengkapnya</a>
        </div>

        @if ($featuredInspirations->isNotEmpty())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($featuredInspirations as $inspiration)
            <article class="rounded-2xl border border-sky-100 bg-white p-4 shadow-sm">
                @if ($inspiration->image_url)
                <img src="{{ $inspiration->image_url }}" alt="{{ $inspiration->title }}" class="mb-4 h-48 w-full rounded-xl object-cover">
                @endif
                <h3 class="font-display text-xl font-semibold text-slate-900">{{ $inspiration->title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $inspiration->summary ?: \Illuminate\Support\Str::limit(strip_tags((string) $inspiration->content), 120) }}</p>
            </article>
            @endforeach
        </div>
        @else
        <div class="rounded-2xl border border-sky-100 bg-white p-6 text-slate-600 shadow-sm">
            Belum ada inspiration. Tambahkan dari admin panel.
        </div>
        @endif
    </section>
</x-layouts.site>