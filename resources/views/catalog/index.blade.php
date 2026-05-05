@extends('layouts.public')

@section('title', 'Katalog Buku')
@section('meta_description', 'Jelajahi katalog buku digital Perpustakaan PNJ, filter berdasarkan kategori, dan cari koleksi dengan cepat.')

@section('content')
    <section class="pnj-shell py-14">
        <div class="pnj-card overflow-hidden p-6 sm:p-8">
            <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
            <div>
                <span class="pnj-pill">Katalog</span>
                    <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950 dark:text-white sm:text-5xl">Cari buku dengan cepat.</h1>
                    <p class="mt-4 max-w-xl text-base leading-8 text-slate-600 dark:text-slate-300">Gunakan pencarian dan filter kategori untuk menemukan koleksi yang relevan. Tampilan ini dirancang mobile-first dan siap dihubungkan ke backend.</p>
                </div>

                <form method="get" class="grid gap-4 rounded-[2rem] border border-slate-200 bg-slate-50 p-5 sm:grid-cols-[1.1fr_0.9fr_auto]">
                    <div>
                        <label for="search" class="pnj-label">Cari</label>
                        <input id="search" name="search" value="{{ $search }}" class="pnj-input" type="search" placeholder="Judul, penulis, penerbit, ISBN">
                    </div>
                    <div>
                        <label for="category" class="pnj-label">Kategori</label>
                        <select id="category" name="category" class="pnj-select pnj-input">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $categoryItem)
                                <option value="{{ $categoryItem['slug'] }}" @selected($category === $categoryItem['slug'])>{{ $categoryItem['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="pnj-button-primary w-full">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="pnj-shell pb-16">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Hasil pencarian</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-950 dark:text-white">{{ count($books) }} buku ditemukan</h2>
            </div>

            @if ($search !== '' || $category !== '')
                <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-slate-600 hover:text-amber-700 dark:text-slate-300 dark:hover:text-amber-300">Reset filter</a>
            @endif
        </div>

        @if (count($books) > 0)
            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($books as $book)
                    @include('partials.book-card', ['book' => $book])
                @endforeach
            </div>
        @else
            <div class="pnj-card mt-8 p-10 text-center">
                <p class="text-lg font-bold text-slate-900">Tidak ada buku yang cocok.</p>
                <p class="mt-3 text-sm text-slate-600">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                <a href="{{ route('catalog.index') }}" class="pnj-button-primary mt-6">Lihat semua buku</a>
            </div>
        @endif
    </section>
@endsection
