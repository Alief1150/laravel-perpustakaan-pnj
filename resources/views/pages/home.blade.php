@extends('layouts.public')

@section('title', 'Perpustakaan PNJ')
@section('meta_description', 'Katalog digital kampus PNJ untuk mencari, membaca, dan mengunduh buku akademik secara cepat dan responsif.')

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.95),transparent_26%),radial-gradient(circle_at_top_right,rgba(251,191,36,0.22),transparent_28%),linear-gradient(to_bottom,#fffdf5,rgba(255,251,235,1))] dark:bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.08),transparent_24%),radial-gradient(circle_at_top_right,rgba(251,191,36,0.14),transparent_24%),linear-gradient(to_bottom,#14110a,rgba(20,17,10,1))]"></div>

        <div class="pnj-shell py-10 sm:py-12 lg:py-24">
            <div class="mx-auto flex max-w-4xl flex-col items-center text-center">
                <span class="pnj-pill">Perpustakaan digital kampus</span>
                <h1 class="mt-5 text-balance text-3xl font-black tracking-tight text-slate-950 dark:text-white sm:text-5xl lg:text-6xl">
                    Akses koleksi kampus dengan pengalaman yang <span class="pnj-gradient-text">bersih, cepat, dan nyaman</span>.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 dark:text-slate-300 sm:mt-6 sm:leading-8 sm:text-lg">
                    Perpustakaan PNJ membantu mahasiswa dan dosen mencari buku, melihat detail koleksi, lalu mengunduh file PDF atau EPUB dengan alur yang sederhana dan aman.
                </p>

                <div class="mt-7 flex w-full flex-col items-stretch justify-center gap-3 sm:w-auto sm:flex-row sm:gap-4">
                    <a href="{{ route('catalog.index') }}" class="pnj-button-primary">Jelajahi Katalog</a>
                    <a href="{{ route('register') }}" class="pnj-button-secondary">Buat Akun</a>
                </div>

                <div class="mt-8 grid w-full gap-3 sm:mt-10 sm:grid-cols-3 sm:gap-4">
                    <div class="pnj-card p-5">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total buku</p>
                        <p class="mt-2 text-3xl font-black text-slate-950 dark:text-white">{{ $stats['books'] }}</p>
                    </div>
                    <div class="pnj-card p-5">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Kategori</p>
                        <p class="mt-2 text-3xl font-black text-slate-950 dark:text-white">{{ $stats['categories'] }}</p>
                    </div>
                    <div class="pnj-card p-5">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Siap unduh</p>
                        <p class="mt-2 text-3xl font-black text-slate-950 dark:text-white">{{ $stats['available'] }}</p>
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-10 w-full max-w-[34rem] lg:mt-14 lg:max-w-none">
                <div class="rounded-[2rem] bg-gradient-to-br from-white via-amber-50 to-amber-200 p-4 text-slate-950 shadow-2xl shadow-amber-950/10 dark:from-[#241d13] dark:via-[#2d240f] dark:to-[#3b2f0d] dark:text-white sm:p-6 lg:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm uppercase tracking-[0.3em] text-amber-800 dark:text-amber-200">Sorotan koleksi</p>
                        <div class="flex gap-2">
                            <button type="button" data-carousel-control="prev" data-carousel-target="#featured-carousel" class="rounded-full border border-amber-200 bg-white px-3 py-2 text-sm font-bold text-amber-800 shadow-sm hover:bg-amber-50 dark:border-amber-800 dark:bg-[#2a220f] dark:text-amber-100" aria-label="Carousel sebelumnya">←</button>
                            <button type="button" data-carousel-control="next" data-carousel-target="#featured-carousel" class="rounded-full border border-amber-200 bg-white px-3 py-2 text-sm font-bold text-amber-800 shadow-sm hover:bg-amber-50 dark:border-amber-800 dark:bg-[#2a220f] dark:text-amber-100" aria-label="Carousel berikutnya">→</button>
                        </div>
                    </div>

                    <div class="mt-6 overflow-hidden">
                        <div id="featured-carousel" data-featured-carousel class="pnj-carousel-track flex items-stretch gap-4 will-change-transform">
                            @foreach ($featuredBooks as $book)
                                @include('partials.featured-cover', ['book' => $book])
                            @endforeach
                        </div>
                    </div>

                    <div data-carousel-dots class="mt-5 flex items-center justify-center gap-2"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="pnj-shell py-6 sm:py-10">
        <div class="pnj-card grid gap-6 p-6 md:grid-cols-3">
            <div>
                <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">01. Pencarian cepat</p>
                <p class="mt-2 text-base leading-7 text-slate-600 dark:text-slate-300">Temukan buku berdasarkan judul, penulis, penerbit, atau ISBN.</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">02. Detail buku</p>
                <p class="mt-2 text-base leading-7 text-slate-600 dark:text-slate-300">Lihat informasi lengkap, ketersediaan file, dan status koleksi.</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">03. Akses aman</p>
                <p class="mt-2 text-base leading-7 text-slate-600 dark:text-slate-300">Alur login dan proteksi file disiapkan untuk tahap backend.</p>
            </div>
        </div>
    </section>

    <section id="koleksi" class="pnj-shell py-16">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="pnj-section-title">Koleksi unggulan</h2>
                <p class="pnj-section-subtitle">Beberapa buku pilihan dari katalog digital PNJ yang paling relevan untuk pembaca kampus.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-800 dark:text-amber-300 dark:hover:text-amber-200">Lihat seluruh katalog</a>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($featuredBooks as $book)
                @include('partials.book-card', ['book' => $book])
            @endforeach
        </div>
    </section>

    <section class="pnj-shell pb-16">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="pnj-card p-8">
                <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Kategori populer</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950 dark:text-white">Katalog disusun agar mudah dipahami dan mudah dipakai.</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">Semua kategori ditata untuk membantu mahasiswa memilih bahan bacaan sesuai jurusan, mata kuliah, dan kebutuhan riset.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($categories as $category)
                    <div class="rounded-3xl border border-amber-100 bg-white p-6 shadow-sm dark:border-amber-900 dark:bg-[#241d13]">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $category['name'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $category['description'] }}</p>
                            </div>
                            <div class="rounded-2xl bg-amber-50 px-3 py-2 text-center text-sm font-black text-amber-700 dark:bg-amber-950 dark:text-amber-200">
                                {{ $category['book_count'] }}
                                <span class="block text-[10px] font-semibold uppercase tracking-[0.24em] text-amber-500 dark:text-amber-300">buku</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
