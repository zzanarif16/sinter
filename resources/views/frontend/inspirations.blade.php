<x-layouts.site :title="'Inspiration - Sumatera Interior'">
    <section class="page-section">
        <div class="page-header">
            <h1 class="page-title">Inspiration</h1>
            <p class="page-subtitle">Koleksi ide desain yang bisa menjadi referensi sebelum memilih produk interior.</p>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($inspirations as $inspiration)
            <article class="surface-card p-6">
                @if ($inspiration->image_url)
                <img src="{{ $inspiration->image_url }}" alt="{{ $inspiration->title }}" class="mb-4 h-48 w-full rounded-xl object-cover">
                @endif
                <h2 class="mt-2 font-display text-xl font-semibold text-slate-900">{{ $inspiration->title }}</h2>
                <p class="mt-3 text-sm text-slate-600">{{ $inspiration->summary ?: \Illuminate\Support\Str::limit(strip_tags((string) $inspiration->content), 120) }}</p>
                <a href="{{ route('inspirations.show', $inspiration->slug) }}" class="mt-4 inline-flex rounded-full bg-sky-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-800">Detail</a>
            </article>
            @empty
            <p class="text-slate-500">Belum ada inspiration. Tambahkan dari admin panel.</p>
            @endforelse
        </div>
    </section>
</x-layouts.site>