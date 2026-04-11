<x-layouts.site :title="$inspiration->title . ' - Inspiration Detail'">
    <section class="page-section">
        <a href="{{ route('inspirations') }}" class="mb-6 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900">&larr; Kembali ke Inspiration</a>

        <article class="surface-card grid gap-8 p-6 lg:grid-cols-2 lg:p-8">
            <div>
                @if ($inspiration->image_url)
                <img src="{{ $inspiration->image_url }}" alt="{{ $inspiration->title }}" class="h-80 w-full rounded-2xl object-cover lg:h-[28rem]">
                @else
                <div class="flex h-80 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 lg:h-[28rem]">No Image</div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold tracking-wide text-sky-700">INSPIRATION</p>
                <h1 class="mt-2 page-title text-3xl sm:text-4xl">{{ $inspiration->title }}</h1>

                @if ($inspiration->summary)
                <p class="mt-4 text-slate-600">{{ $inspiration->summary }}</p>
                @endif

                @if ($inspiration->content)
                <div class="prose prose-slate mt-6 max-w-none text-sm text-slate-700">
                    {!! $inspiration->content !!}
                </div>
                @endif
            </div>
        </article>

        @if ($relatedInspirations->isNotEmpty())
        <section class="mt-12">
            <h2 class="font-display text-2xl font-bold text-slate-900">Inspiration Lainnya</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedInspirations as $item)
                <article class="surface-card p-4">
                    @if ($item->image_url)
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="mb-3 h-36 w-full rounded-xl object-cover">
                    @endif
                    <h3 class="font-display text-base font-semibold text-slate-900">{{ $item->title }}</h3>
                    <a href="{{ route('inspirations.show', $item->slug) }}" class="mt-3 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900">Lihat Detail</a>
                </article>
                @endforeach
            </div>
        </section>
        @endif
    </section>
</x-layouts.site>