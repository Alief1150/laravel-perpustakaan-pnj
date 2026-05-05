@php
    $accent = $book['accent'];
@endphp

<article data-carousel-slide class="shrink-0 w-[13.5rem] sm:w-[15rem] md:w-[16rem]">
    <a href="{{ route('catalog.show', $book['slug']) }}" class="group block">
        <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] border border-amber-100 bg-white shadow-[0_18px_40px_rgba(0,0,0,0.12)] transition duration-300 group-hover:-translate-y-1 dark:border-amber-900 dark:bg-[#241d13]" style="background: linear-gradient(160deg, {{ $accent['from'] }}, {{ $accent['via'] }}, {{ $accent['to'] }});">
            @if (! empty($book['cover_url']))
                <img src="{{ $book['cover_url'] }}" alt="Cover {{ $book['title'] }}" class="absolute inset-0 h-full w-full object-cover">
            @endif
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.45),transparent_38%),radial-gradient(circle_at_bottom_right,rgba(0,0,0,0.08),transparent_35%)]"></div>
            <div class="absolute left-0 top-0 h-full w-6 bg-black/10"></div>
            <div class="relative flex h-full flex-col justify-between p-5">
                <div class="flex items-start justify-between gap-3">
                    <span class="rounded-full bg-white/80 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.3em] text-amber-800 shadow-sm">
                        {{ $book['category_name'] }}
                    </span>
                    <span class="rounded-full bg-black/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.3em] text-slate-900">
                        {{ $book['publication_year'] }}
                    </span>
                </div>

                <div class="space-y-3">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.4em] text-slate-800/80">Perpustakaan PNJ</p>
                    <h3 class="text-2xl font-black leading-tight text-slate-950 drop-shadow-sm">{{ $book['title'] }}</h3>
                    <p class="text-sm font-medium text-slate-800/80">{{ $book['author'] }}</p>
                </div>
            </div>
        </div>
    </a>
</article>
