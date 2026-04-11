<x-layouts.site :title="'About - Sumatera Interior'">
    <section class="page-section">
        <article class="surface-card p-6 sm:p-8">
            <h1 class="page-title text-3xl sm:text-4xl">{{ $about?->title ?? 'About' }}</h1>
            @if ($about?->image_url)
            <img src="{{ $about->image_url }}" alt="{{ $about->title }}" class="mt-5 h-72 w-full rounded-2xl object-cover sm:h-96">
            @endif
            <p class="page-subtitle max-w-4xl">{{ $about?->headline ?? 'Tambahkan headline about dari CMS.' }}</p>
            <div class="mt-6 space-y-4 text-sm leading-relaxed text-slate-600">
                <p>{{ $about?->content }}</p>
                <p><span class="font-semibold text-slate-900">Vision:</span> {{ $about?->vision ?? '-' }}</p>
                <p><span class="font-semibold text-slate-900">Mission:</span> {{ $about?->mission ?? '-' }}</p>
            </div>
        </article>
    </section>
</x-layouts.site>