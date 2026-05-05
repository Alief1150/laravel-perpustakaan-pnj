<header class="sticky top-0 z-50 border-b border-amber-100/80 bg-white/90 backdrop-blur dark:border-amber-900/60 dark:bg-[#18130b]/90">
    <div class="pnj-shell flex items-center justify-between gap-4 py-4">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 via-yellow-300 to-amber-600 text-white shadow-lg shadow-amber-500/20 dark:from-amber-500 dark:via-yellow-400 dark:to-amber-700 dark:text-slate-950">
                <span class="text-lg font-black">PNJ</span>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Perpustakaan PNJ</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Digital library campus</p>
            </div>
        </a>

        <nav class="hidden items-center gap-2 lg:flex">
            <a href="{{ url('/') }}" class="rounded-full px-4 py-2 text-sm font-medium text-slate-600 hover:bg-amber-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-[#2a220f] dark:hover:text-white">Beranda</a>
            <a href="{{ route('catalog.index') }}" class="rounded-full px-4 py-2 text-sm font-medium text-slate-600 hover:bg-amber-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-[#2a220f] dark:hover:text-white">Katalog</a>
            <a href="{{ url('/#koleksi') }}" class="rounded-full px-4 py-2 text-sm font-medium text-slate-600 hover:bg-amber-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-[#2a220f] dark:hover:text-white">Koleksi</a>
            <button type="button" data-theme-toggle class="pnj-button-secondary ml-2 gap-2">
                <span class="theme-icon-light">☀</span>
                <span class="theme-icon-dark hidden">☾</span>
                <span class="sr-only">Toggle tema</span>
            </button>
            @auth
                @if(auth()->user()?->role === 'admin')
                    <a href="{{ url('/admin') }}" class="pnj-button-primary">Dashboard Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="post" class="ml-2">
                    @csrf
                    <button type="submit" class="pnj-button-secondary">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="pnj-button-secondary">Masuk</a>
                <a href="{{ route('register') }}" class="pnj-button-primary">Daftar</a>
            @endauth
        </nav>

        <div class="relative lg:hidden" data-mobile-menu>
            <button
                type="button"
                data-mobile-menu-button
                aria-expanded="false"
                aria-controls="mobile-menu-panel"
                class="rounded-2xl border border-amber-100 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-amber-50 dark:border-amber-900 dark:bg-[#241d13] dark:text-slate-200 dark:hover:bg-[#2a220f]"
            >
                Menu
            </button>

            <div
                id="mobile-menu-panel"
                data-mobile-menu-panel
                class="pointer-events-none absolute right-0 top-14 w-[calc(100vw-2rem)] max-w-sm origin-top-right scale-95 overflow-hidden rounded-3xl border border-amber-100 bg-white p-2 opacity-0 shadow-xl shadow-slate-900/10 transition-all duration-300 ease-out dark:border-amber-900 dark:bg-[#241d13]"
            >
                <button type="button" data-theme-toggle class="block w-full rounded-2xl px-4 py-3 text-left text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Toggle tema</button>
                <a href="{{ url('/') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Beranda</a>
                <a href="{{ route('catalog.index') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Katalog</a>
                @auth
                    @if(auth()->user()?->role === 'admin')
                        <a href="{{ url('/admin') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Dashboard Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="post" class="block">
                        @csrf
                        <button type="submit" class="block w-full rounded-2xl px-4 py-3 text-left text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Masuk</a>
                    <a href="{{ route('register') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-amber-50 dark:text-slate-200 dark:hover:bg-[#2a220f]">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</header>
