<footer class="mt-16 border-t border-amber-100 bg-white dark:border-amber-900 dark:bg-[#18130b]">
    <div class="pnj-shell grid gap-10 py-10 md:grid-cols-3">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Perpustakaan PNJ</h3>
            <p class="mt-3 max-w-sm text-sm leading-6 text-slate-600 dark:text-slate-300">
                Katalog digital untuk mendukung pencarian, peminjaman, dan akses file buku secara aman bagi sivitas kampus.
            </p>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Navigasi</p>
            <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                <li><a href="{{ url('/') }}" class="hover:text-amber-700 dark:hover:text-amber-300">Beranda</a></li>
                <li><a href="{{ route('catalog.index') }}" class="hover:text-amber-700 dark:hover:text-amber-300">Katalog</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-amber-700 dark:hover:text-amber-300">Masuk</a></li>
            </ul>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Catatan</p>
            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                Frontend ini dibangun sebagai fondasi UI publik. Integrasi autentikasi, database, dan panel admin akan menyusul pada tahap backend.
            </p>
        </div>
    </div>
    <div class="border-t border-amber-100 dark:border-amber-900">
        <div class="pnj-shell py-4 text-center text-sm text-slate-500 dark:text-slate-400">All rights MVP Perpustakaan PNJ 2026</div>
    </div>
</footer>
