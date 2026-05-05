@php
    $accent = $book['accent'];
@endphp

<article class="group h-full overflow-hidden rounded-[2rem] border border-amber-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-950/10 dark:border-amber-900 dark:bg-[#241d13]">
    <div class="p-4">
        <a href="{{ route('catalog.show', $book['slug']) }}" class="block">
            <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] border border-amber-100 text-slate-950 shadow-lg dark:border-amber-800" style="background: linear-gradient(160deg, {{ $accent['from'] }}, {{ $accent['via'] }}, {{ $accent['to'] }});">
                @if (! empty($book['cover_url']))
                    <img src="{{ $book['cover_url'] }}" alt="Cover {{ $book['title'] }}" class="absolute inset-0 h-full w-full object-cover">
                @endif
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.55),transparent_40%),radial-gradient(circle_at_bottom_right,rgba(0,0,0,0.06),transparent_35%)]"></div>
                <div class="absolute left-0 top-0 h-full w-5 bg-black/10"></div>
                <div class="relative flex h-full flex-col justify-between p-5">
                    <div class="flex items-start justify-between gap-3">
                        <span class="rounded-full bg-white/80 px-3 py-1 text-[10px] font-black uppercase tracking-[0.24em] text-amber-800">
                            {{ $book['category_name'] }}
                        </span>
                        <span class="rounded-full bg-black/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.24em] text-slate-900">
                            {{ strtoupper($book['status']) }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.4em] text-slate-800/80">Perpustakaan PNJ</p>
                        <h3 class="text-2xl font-black leading-tight text-slate-950 drop-shadow-sm">{{ $book['title'] }}</h3>
                        <p class="text-sm font-medium text-slate-800/80">{{ $book['author'] }}</p>
                    </div>
                </div>
            </div>

            <div class="px-1 pb-1 pt-5">
                <p class="text-lg font-bold leading-snug text-slate-900 group-hover:text-amber-700 dark:text-white dark:group-hover:text-amber-300">{{ $book['title'] }}</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $book['author'] }} · {{ $book['publisher'] }}</p>

                <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-700 dark:bg-[#2a220f] dark:text-slate-200">Stok {{ $book['stock'] }}</span>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-amber-700 dark:bg-amber-950 dark:text-amber-200">{{ $book['category_name'] }}</span>
                </div>
            </div>
        </a>
    </div>
</article>
