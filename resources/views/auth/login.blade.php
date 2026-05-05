@extends('layouts.public')

@section('title', 'Masuk')

@section('content')
    <section class="pnj-shell py-14">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-stretch">
            <div class="pnj-card bg-slate-950 p-8 text-white">
                <p class="text-sm font-semibold text-amber-300">Akses anggota</p>
                <h1 class="mt-4 text-4xl font-black tracking-tight">Masuk untuk mengakses katalog penuh dan unduhan.</h1>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300">Halaman ini sudah disiapkan secara visual. Pada tahap backend nanti, form akan dihubungkan ke autentikasi Laravel dan middleware proteksi file.</p>
            </div>

            <div class="pnj-card p-8">
                <form class="space-y-5" action="{{ route('login.store') }}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div>
                        <label class="pnj-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="pnj-input" value="{{ old('email') }}" placeholder="nama@pnj.ac.id" autocomplete="email">
                    </div>
                    <div>
                        <label class="pnj-label" for="password">Password</label>
                        <input id="password" name="password" type="password" class="pnj-input" placeholder="Masukkan password" autocomplete="current-password">
                    </div>
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <label class="flex items-center gap-2 text-slate-600">
                            <input type="checkbox" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                            Ingat saya
                        </label>
                        <a href="{{ route('register') }}" class="font-semibold text-amber-700 hover:text-amber-800">Buat akun</a>
                    </div>
                    <button type="submit" class="pnj-button-primary w-full">Masuk ke akun</button>
                </form>
            </div>
        </div>
    </section>
@endsection
