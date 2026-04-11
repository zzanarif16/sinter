<x-layouts.site :title="'About - Sumatera Interior'">
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="font-display text-3xl font-bold text-slate-900">{{ $about?->title ?? 'About' }}</h1>
            @if ($about?->image_url)
            <img src="{{ $about->image_url }}" alt="{{ $about->title }}" class="mt-4 h-100 w-full rounded-2xl object-cover">
            @endif
            <p class="mt-4 text-slate-600">{{ $about?->headline ?? 'Tambahkan headline about dari CMS.' }}</p>
            <div class="mt-6 space-y-4 text-sm text-slate-600">
                <p>{{ $about?->content }}</p>
                <p><span class="font-semibold text-slate-900">Vision:</span> {{ $about?->vision ?? '-' }}</p>
                <p><span class="font-semibold text-slate-900">Mission:</span> {{ $about?->mission ?? '-' }}</p>
            </div>
        </article>
    </section>
</x-layouts.site>