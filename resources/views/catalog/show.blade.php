@extends('layouts.public')

@section('title', $book['title'])
@section('meta_description', $book['description'])

@section('content')
    <section class="pnj-shell py-14">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="rounded-[2rem] border border-amber-100/80 bg-gradient-to-br from-white via-amber-50 to-amber-100 p-6 text-slate-950 shadow-2xl shadow-amber-950/10 dark:border-amber-900 dark:from-[#241d13] dark:via-[#2d240f] dark:to-[#3b2f0d] dark:text-white">
                <div class="flex min-h-[28rem] flex-col justify-between rounded-[1.5rem] border border-amber-100/80 bg-white/80 p-6 backdrop-blur dark:border-amber-900 dark:bg-[#1d180f]/70">
                    <div class="space-y-5">
                        @if (! empty($book['cover_url']))
                            <div class="overflow-hidden rounded-[1.5rem] border border-amber-100 bg-white shadow-lg dark:border-amber-900">
                                <img src="{{ $book['cover_url'] }}" alt="Cover {{ $book['title'] }}" class="h-[22rem] w-full object-cover">
                            </div>
                        @endif

                        <div class="flex items-center justify-between gap-4">
                            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-amber-800 dark:border-amber-700 dark:bg-[#2a220f] dark:text-amber-200">{{ $book['category_name'] }}</span>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 dark:bg-amber-950 dark:text-amber-200">{{ strtoupper($book['status']) }}</span>
                        </div>

                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-700 dark:text-slate-300">Perpustakaan PNJ</p>
                            <h1 class="mt-4 text-4xl font-black leading-tight text-slate-950 dark:text-white sm:text-5xl">{{ $book['title'] }}</h1>
                            <p class="mt-4 max-w-xl text-base leading-8 text-slate-950 dark:text-slate-200">{{ $book['description'] }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="rounded-2xl bg-amber-50 p-4 dark:bg-[#2a220f]">
                                <p class="text-slate-600 dark:text-slate-400">Penulis</p>
                                <p class="mt-1 font-semibold text-slate-950 dark:text-white">{{ $book['author'] }}</p>
                            </div>
                            <div class="rounded-2xl bg-amber-50 p-4 dark:bg-[#2a220f]">
                                <p class="text-slate-600 dark:text-slate-400">Tahun</p>
                                <p class="mt-1 font-semibold text-slate-950 dark:text-white">{{ $book['publication_year'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="pnj-card p-6 sm:p-8">
                    <h2 class="text-2xl font-black text-slate-950 dark:text-white">Informasi Buku</h2>
                    <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Author</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $book['author'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Publisher</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $book['publisher'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">ISBN</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $book['isbn'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Stok</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $book['stock'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Kategori</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $book['category_name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Status</dt>
                            <dd class="mt-1 font-semibold text-slate-900 dark:text-white">{{ ucfirst($book['status']) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="pnj-card p-6 sm:p-8">
                    <h2 class="text-2xl font-black text-slate-950 dark:text-white">Unduhan</h2>
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Frontend ini menyiapkan alur unduh yang nanti akan dilindungi autentikasi pada backend.</p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('books.download.pdf', $book['slug']) }}" class="pnj-button-primary {{ $book['pdf_available'] ? '' : 'pointer-events-none opacity-50' }}">
                            {{ $book['pdf_available'] ? 'Unduh PDF' : 'PDF Tidak Tersedia' }}
                        </a>
                        <a href="{{ route('books.download.epub', $book['slug']) }}" class="pnj-button-secondary {{ $book['epub_available'] ? '' : 'pointer-events-none opacity-50' }}">
                            {{ $book['epub_available'] ? 'Unduh EPUB' : 'EPUB Tidak Tersedia' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (count($relatedBooks) > 0)
        <section class="pnj-shell pb-16">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="pnj-section-title">Rekomendasi serupa</h2>
                    <p class="pnj-section-subtitle">Buku lain dalam kategori yang sama.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-800 dark:text-amber-300 dark:hover:text-amber-200">Lihat katalog</a>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($relatedBooks as $relatedBook)
                    @include('partials.book-card', ['book' => $relatedBook])
                @endforeach
            </div>
        </section>
    @endif
@endsection
