@extends('layouts.public')

@section('title', 'Daftar')

@section('content')
    <section class="pnj-shell py-14">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-stretch">
            <div class="pnj-card bg-gradient-to-br from-amber-300 via-yellow-200 to-amber-500 p-8 text-slate-950 dark:from-amber-500 dark:via-yellow-400 dark:to-amber-700 dark:text-slate-950">
                <p class="text-sm font-semibold text-amber-900/80 dark:text-slate-950/80">Pendaftaran anggota</p>
                <h1 class="mt-4 text-4xl font-black tracking-tight">Buat akun untuk mahasiswa dan dosen.</h1>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-800/90 dark:text-slate-950/90">Frontend pendaftaran ini menjadi fondasi sebelum integrasi autentikasi dan role user pada backend.</p>
            </div>

            <div class="pnj-card p-8">
                <form class="grid gap-5 sm:grid-cols-2" action="{{ route('register.store') }}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="sm:col-span-2 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div class="sm:col-span-2">
                        <label class="pnj-label" for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text" class="pnj-input" value="{{ old('name') }}" placeholder="Nama lengkap" autocomplete="name">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="pnj-label" for="email-register">Email</label>
                        <input id="email-register" name="email" type="email" class="pnj-input" value="{{ old('email') }}" placeholder="nama@pnj.ac.id" autocomplete="email">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="pnj-label" for="user_type">Jenis Pengguna</label>
                        <select id="user_type" name="user_type" class="pnj-select">
                            <option value="student" @selected(old('user_type', 'student') === 'student')>Student</option>
                            <option value="teacher" @selected(old('user_type') === 'teacher')>Teacher</option>
                        </select>
                    </div>
                    <div>
                        <label class="pnj-label" for="password-register">Password</label>
                        <input id="password-register" name="password" type="password" class="pnj-input" placeholder="Password baru" autocomplete="new-password">
                    </div>
                    <div>
                        <label class="pnj-label" for="password-confirm">Konfirmasi</label>
                        <input id="password-confirm" name="password_confirmation" type="password" class="pnj-input" placeholder="Ulangi password" autocomplete="new-password">
                    </div>
                    <div class="sm:col-span-2 flex items-center justify-between gap-4 text-sm">
                        <p class="text-slate-600 dark:text-slate-300">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-amber-700 hover:text-amber-800 dark:text-amber-300 dark:hover:text-amber-200">Masuk</a></p>
                        <button type="submit" class="pnj-button-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
